<?php
  session_start();

  if(!isset($_SESSION['user']))
  {   //Verifie si l'utilisateur est connecter entant que client
     header("Location: payment.php");//si non le redirige vers la page de connexion
  }
 
  if(empty($_SESSION['user']))
  {
     header("Location: login.php");
  }
  if(!isset($_GET['pdt']))
    {
        header("Location: index.php");
    }

    if(empty($_GET['pdt']) AND is_int($_GET['pdt']))
    {
        header("Location: payment.php");
    }
  require("config/commandes.php");
  require_once 'config/connexion.php';
  require_once __DIR__ . '/src/cinetpay.php';
  
  // Récupérer l'ID du produit via GET
    $product_id = $_GET['pdt'] ?? null;

    if ($product_id) {
        // Récupérer les détails du produit depuis la base de données
        $sql = "SELECT prix FROM produits WHERE id = :product_id";
        $stmt = $access->prepare($sql);
        $stmt->execute([':product_id' => $product_id]);
        $produit = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$product_id) {
            die("Produit non trouvé.");
        }

        $product_price = $produit['prix']; // Le prix du produit
    } else {
        die("Aucun produit sélectionné.");
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement Monoshop</title>
    <!-- Lien vers la feuille de style Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div style="display: flex; justify-content:flex-end">
        <a href="./admin/deconnexion.php" class="btn btn-danger">Se déconnecter</a>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1 class="text-center mb-4">Paiement sur Monoshop</h1>
                
                <!-- Formulaire de paiement -->
                <form  method="POST" class="border p-4 bg-light shadow-sm rounded">
                    
                    <!-- Champ Nom -->
                    <div class="mb-3">
                        <label for="customer_name" class="form-label">Nom complet</label>
                        <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Entrez votre nom" required>
                    </div>

                    <!-- Champ Email -->
                    <div class="mb-3">
                        <label for="customer_email" class="form-label">Adresse Email</label>
                        <input type="email" class="form-control" id="customer_email" name="customer_email" placeholder="Entrez votre email" required>
                    </div>

                    <!-- Champ Montant -->
                    <div class="mb-3">
                        <label for="amount" class="form-label">Montant à payer (en XOF)</label>
                        <input type="number" class="form-control" id="amount" name="amount" min="100" placeholder="Montant en francs CFA" value="<?= $product_price ?>" readonly>
                    </div>

                    <!-- Bouton de soumission -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary" name="payer">Procéder au paiement</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Lien vers le script JavaScript Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

<?php
    // Vérifier que le formulaire a bien été soumis
    if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    {
        if (isset($_POST['payer'])) {
            // Vérifier que les champs requis sont définis et non vides
            if (isset($_POST['customer_name'], $_POST['customer_email'], $_POST['amount']) &&
                !empty($_POST['customer_name']) && 
                !empty($_POST['customer_email']) && 
                !empty($_POST['amount'])) 
            {
                // Récupérer les informations du formulaire
                $customer_name = $_POST['customer_name'];
                $customer_email = $_POST['customer_email'];
                $amount = $_POST['amount'];

                // Informations d'authentification CinetPay
                $apikey = "10268784926704001ca46639.57506760"; // Remplace par ta clé API CinetPay
                $site_id = "5881557"; // Remplace par ton site ID
                $transaction_id = uniqid(); // Génère un ID de transaction unique
                $currency = 'XOF'; // Monnaie utilisée (franc CFA)
                $description = "Achat sur Monoshop"; // Description de la commande

                // URL de retour et de notification (pour le développement local)
                $return_url = "http://localhost/monoshop/payment_return.php";
                $notify_url = "http://localhost/monoshop/payment_notify.php";

                // Construire les données pour l'API CinetPay
                $data = [
                    'apikey' => $apikey,
                    'site_id' => $site_id,
                    'transaction_id' => $transaction_id,
                    'amount' => $amount,
                    'currency' => $currency,
                    'description' => $description,
                    'return_url' => $return_url,
                    'notify_url' => $notify_url,
                    'customer_name' => $customer_name,
                    'customer_email' => $customer_email,
                ];

                // Envoyer la requête vers l'API CinetPay
                $ch = curl_init('https://api-checkout.cinetpay.com/v2/payment');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

                // Exécuter la requête
                $response = curl_exec($ch);
                curl_close($ch);
                
                // Traiter la réponse
                $result = json_decode($response, true);

                // Vérifier si le décodage a échoué
                if (json_last_error() !== JSON_ERROR_NONE) {
                    echo "Erreur lors du décodage de la réponse JSON : " . json_last_error_msg();
                    exit();
                }
               
                // Vérifier la réponse de l'API CinetPay
                if (isset($result['code']) && $result['code'] == "201") {
                    // Vérifier que l'URL de paiement existe
                    if (isset($result['data']['payment_url'])) {
                        // Enregistrer la commande dans la table orders
                        $sql = "INSERT INTO orders (product_id, customer_name, customer_email, total_amount, payment_status, transaction_id) 
                        VALUES (:product_id, :customer_name, :customer_email, :total_amount, 'pending', :transaction_id)";
                        $stmt = $access->prepare($sql);
                        $stmt->execute([
                            ':product_id' => $product_id,
                            ':customer_name' => $customer_name,
                            ':customer_email' => $customer_email,
                            ':total_amount' => $amount,
                            ':transaction_id' => $transaction_id
                        ]);
                        // Rediriger l'utilisateur vers l'URL de paiement CinetPay
                        header('Location: ' . $result['data']['payment_url']);
                        exit();
                    } else {
                        echo "URL de paiement non trouvée.";
                    }
                } else {
                    // En cas d'erreur, afficher un message
                    echo "Une erreur est survenue lors de la tentative de paiement : " . $result['message'];
                }
            } else {
                echo "Veuillez remplir tous les champs requis.";
            }
        } else {
            echo "Méthode de requête non autorisée.";
        }
    }
    ?>

</html>

