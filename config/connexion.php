<?php
function getDatabaseConnection() {
    $access = null;
    try {
        // Connexion à la base de données
        $access = new PDO("mysql:host=localhost;dbname=monoshop;charset=utf8", "root", "");

        // Option de gestion d'erreurs
        $access->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

    } catch (Exception $e) {
        // Affichage de l'erreur en cas de problème de connexion
        echo "Erreur de connexion : " . $e->getMessage(); 
    }
    return $access;
}
?>
