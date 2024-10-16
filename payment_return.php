<?php
    // Vérifie si la transaction a réussi ou échoué en fonction des paramètres GET/POST
    if (isset($_GET['status']) && $_GET['status'] == "success") {
        echo "Paiement réussi ! Merci pour votre achat.";
        // Mettre à jour la base de données avec le statut de la commande
    } else {
        echo "Le paiement a échoué. Veuillez réessayer.";
    }
?>
