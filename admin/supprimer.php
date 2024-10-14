<?php
 session_start();

 if(!isset($_SESSION['admin'])){   //Verifie si l'utilisateur est connecter entant que admin
    header("Location: ../login.php");//si non le redirige vers la page de connexion
 }

 if(empty($_SESSION['admin'])){
    header("Location: ../login.php");
 }
 require("../config/commandes.php");
 $produits=afficher();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>   
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid" style="width: 90%;">
    <a class="navbar-brand" href="../index.php" style="font-size: 1.5rem;">Acceuil</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="index.php" style="font-size: 1.5rem;">Ajouter</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="#" style="font-size: 1.5rem;font-weight:bold;">Suppression</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="afficher.php" style="font-size: 1.5rem;">Produits</a>
        </li>
      </ul>
      <div style="display: flex; justify-content:flex-end">
        <a href="deconnexion.php" class="btn btn-danger">Se déconnecter</a>
      </div>
    </div>
  </div>
</nav>
<div class="container">
    <div class="row">
        <div class="col-sm-8 col-md-7 py-4">
        <form method="post">

            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Identifiant du produit</label>
                <input type="number" name="idproduit" class="form-control" required>
            </div>
            
            <button type="submit" name="supprimer" class="btn btn-warning">Supprimer le produit</button><br><br><br>

        </form>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
        <?php foreach($produits as $produit): ?>
            <div class="row">
            <div class="card shadow-sm">
            <img src="<?= $produit->image ?>" alt="" style="width: 100px; height: 100px;">
            <h3><?= $produit->id ?></h3>
            </div>
            </div>
        <?php endforeach; ?>
      </div>
    </div>
       
    </div>
    
</div>

<?php

    if (isset($_POST['supprimer'])) 
    {
        if (isset($_POST['idproduit'])) 
        {
           
            if (!empty($_POST['idproduit']) AND is_numeric($_POST['idproduit'])) 
            {
                $idproduit = htmlspecialchars($_POST['idproduit']);
                
                try {
                    supprimer($idproduit);
                    header("Location: afficher.php");
            
                } catch (Exception $e) {
                    // Affichage de l'erreur en cas de problème 
                    echo "Erreur de suppression: " . $e->getMessage(); 
                }
            }
        }
    }
?>

</body>
</html>