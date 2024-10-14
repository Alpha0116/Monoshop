<?php
require_once 'connexion.php';

$access = getDatabaseConnection(); // Connexion à la base de données.

/**
 * Modifier un produit.
 */
function getProduit($id){
    global $access;
    $req = $access->prepare("SELECT * FROM produits WHERE id=?");
    $req->execute(array($id));
    if($req->rowCount() == 1){
        $data= $req->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }else
    {
        return false;
    }
    $req->closeCursor();
}

function modifier($image, $nom, $prix, $desc, $id) {
    global $access;
    $req = $access->prepare("UPDATE produits SET image=?, nom=?, prix=?, description=? WHERE id=?");
    $req->execute(array($image, $nom, $prix, $desc, $id));
    $req->closeCursor();
}
/**
 * Se connecter entant que administrateur.
 */
function getAdmin($email, $password){
    global $access;
    $req = $access->prepare("SELECT * FROM admin WHERE email=? AND password=?");
    $req->execute(array($email, $password));
    if($req->rowCount() == 1){
        $data= $req->fetch();
        return $data;
    }else
    {
        return false;
    }
    $req->closeCursor();
}

/**
 * Ajoute un produit dans la base de données.
 */
function ajouter($image, $nom, $prix, $desc) {
    global $access;
    $req = $access->prepare("INSERT INTO produits(image, nom, prix, description) VALUES (?, ?, ?, ?)");
    $req->execute(array($image, $nom, $prix, $desc));
    $req->closeCursor();
}

/**
 * Récupère tous les produits depuis la base de données.
 */
function afficher() {
    global $access;
    $req = $access->prepare("SELECT * FROM produits ORDER BY id DESC");
    $req->execute();

    $data = $req->fetchAll(PDO::FETCH_OBJ);
    $req->closeCursor();

    return $data;
}

/**
 * Supprime un produit de la base de données par son ID.
 */
function supprimer($id) {
    global $access;
    $req = $access->prepare("DELETE FROM produits WHERE id=?");
    $req->execute(array($id));
    $req->closeCursor();
}
?>
