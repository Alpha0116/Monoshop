<?php
    session_start();

    if(isset($_SESSION['admin']))
    {   //Verifie si l'utilisateur est déja connecter entant que admin
        if(!empty($_SESSION['admin']))
        {
           header("Location: admin/");
        }
    }elseif(isset($_SESSION['user']))
    {   //Verifie si l'utilisateur est déja connecter entant que client
        if(!empty($_SESSION['user']))
        {
           header("Location: payment.php");
        }
    }
   
    include"config/commandes.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login-monoshop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
            <br><br><br><br>
            <form method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" style="width: 80%;">
                </div>
                <div class="mb-3">
                    <label for="motdepasse" class="form-label">Mot de passe</label>
                    <input type="password" name="motdepasse" class="form-control" class="motdepasse" style="width: 80%;">
                </div>
                <input type="submit" class="btn btn-primary" value="Se connecter" name="envoyer">
            </form>

            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
</body>
</html>

<?php

    if(isset($_POST['envoyer']))
    {
        if(!empty($_POST['email']) AND !empty($_POST['motdepasse']))
        {
            $email=htmlspecialchars($_POST['email']);
            $motdepasse=htmlspecialchars($_POST['motdepasse']);
            $admin=getAdmin($email, $motdepasse) or $admin=getUser($email, $motdepasse);

            if($admin=getAdmin($email, $motdepasse))
            {
                $_SESSION['admin']= $admin;
                header("Location: admin/afficher.php");
            }elseif($admin=getUser($email, $motdepasse))
            {
                $_SESSION['user']= $admin;
                header("Location: payment.php");
            }else
            {
                echo"Email ou mot de passe incorrect";
            }
        }else{
            echo"Veuillez rien tous les champs";
        }
    }

?>