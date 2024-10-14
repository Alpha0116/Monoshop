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
    <title>Tous les produits</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
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
            <a class="nav-link" href="supprimer.php" style="font-size: 1.5rem;">Suppression</a>
            </li>
            <li class="nav-item">
            <a class="nav-link active" href="afficher.php" style="font-size: 1.5rem;font-weight:bold;">Produits</a>
            </li>
        </ul>
        <div style="display: flex; justify-content:flex-end">
            <a href="deconnexion.php" class="btn btn-danger">Se déconnecter</a>
        </div>
        </div>
    </div>
    </nav>
    <div class="album py-5 bg-light">

        <div class="container">
                
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Image</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Prix</th>
                        <th scope="col">Description</th>
                        <th scope="col">Editer</th>
                        </tr>    
                    </thead>
                    <tbody>
                        <?php foreach($produits as $produit): ?>
                            <tr>
                            <th scope="row"><?= $produit->id ?></th>
                            <td>
                                <img src="<?= $produit->image ?>" alt="" style="width: 15%;">
                            </td>
                            <td><?= $produit->nom ?></td>
                            <td style="font-weight: bold;color:green"><?= $produit->prix ?>€</td>
                            <td><?= substr("$produit->description",0,100) ?>...</td>
                            <td>
                                <a href="editer.php?pdt=<?= $produit->id ?>"><i class="fa fa-pen" style="font-size: 180%;"></i></a>
                            </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>

</body>
</html>