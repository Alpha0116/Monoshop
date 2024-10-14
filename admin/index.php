<?php
 session_start();

 if(!isset($_SESSION['admin']))
 {   //Verifie si l'utilisateur est connecter entant que admin
    header("Location: ../login.php");//si non le redirige vers la page de connexion
 }

 if(empty($_SESSION['admin']))
 {
    header("Location: ../login.php");
 }
 require("../config/commandes.php");
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
          <a class="nav-link active" aria-current="page" href="#" style="font-size: 1.5rem;font-weight:bold;">Ajouter</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="supprimer.php" style="font-size: 1.5rem;">Suppression</a>
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
                <label for="exampleInputEmail1" class="form-label">Titre de l'image</label>
                <input type="name" name="image" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Nom du produit</label>
                <input type="text" name="nom" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Prix</label>
                <input type="number" name="prix" class="form-control" required>
            </div>
            
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Description</label>
                <textarea name="desc" id="" class="form-control" required></textarea>
            </div>

            <button type="submit" name="ajouter" class="btn btn-success">Ajouter un nouveau produit</button>
            

        </form>
        </div>
    </div>
</div>

<?php

    if (isset($_POST['ajouter'])) 
    {
        if (isset($_POST['image']) AND isset($_POST['nom']) AND isset($_POST['prix']) AND isset($_POST['desc'])) 
        {
           
            if (!empty($_POST['image']) AND !empty($_POST['nom']) AND !empty($_POST['prix']) AND !empty($_POST['desc'])) 
            {
                $image = htmlspecialchars($_POST['image']);
                $nom = htmlspecialchars($_POST['nom']);
                $prix = htmlspecialchars($_POST['prix']);
                $desc = htmlspecialchars($_POST['desc']);
                
                try {
                    ajouter($image, $nom, $prix, $desc);
                    header("Location: afficher.php");
            
                } catch (Exception $e) {
                    // Affichage de l'erreur en cas de problème 
                    echo "Erreur d'ajout : " . $e->getMessage(); 
                }
            }
        }
    }
?>

</body>
</html>