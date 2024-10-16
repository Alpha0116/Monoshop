<?php
    // Récupère les informations de la notification envoyée par CinetPay
    $apikey = "10268784926704001ca46639.57506760";
    $transaction_id = $_POST['transaction_id']; // Transaction ID reçue de CinetPay

    // Vérifie l'état de la transaction
    $data = [
        'apikey' => $apikey,
        'transaction_id' => $transaction_id,
    ];

    $ch = curl_init('https://api.cinetpay.com/v1/transaction/check');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);

    if (isset($result['code']) && $result['code'] == "00") {
        // Paiement validé, mettre à jour le statut de la commande
        // Mise à jour de la base de données ici
    } else {
        // Le paiement a échoué ou est en attente
    }
?>
