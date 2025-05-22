<?php
require_once '../config/database.php';
session_start();

if (isset($_SESSION['user_id']) && isset($_POST['event_id'])) {
    $userId = $_SESSION['user_id'];
    $eventId = $_POST['event_id'];

    // Vérifier que l'utilisateur est bien l'organisateur de cet événement
    $stmt = $pdo->prepare("SELECT id_organisateur FROM evenement WHERE idEvenement = ?");
    $stmt->execute([$eventId]);
    $event = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($event && $event['id_organisateur'] == $userId) {
        // Mettre à jour l'événement comme lancé
        $update = $pdo->prepare("UPDATE evenement SET est_commence = 1 WHERE idEvenement = ?");
        $update->execute([$eventId]);

        // Rediriger avec succès
        header("Location: ../pages/evenement.php?success=start");
        exit;
    } else {
        header("Location: ../pages/evenement.php?erreur=unauthorized");
        exit;
    }
} else {
    header("Location: ../pages/evenement.php?erreur=invalid");
    exit;
}
