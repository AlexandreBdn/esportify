<?php
session_start();
require_once '../config/database.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_tournoi'])) {
    $idEvent = (int) $_POST['id_tournoi'];


    // Vérifier que l'utilisateur est bien l'organisateur du tournoi
    $stmtCheck = $pdo->prepare("SELECT id_organisateur FROM evenement WHERE idEvenement = ?");
    $stmtCheck->execute([$idEvent]);
    $event = $stmtCheck->fetch(PDO::FETCH_ASSOC);


   if (
    !$event ||
    (
        $_SESSION['user_role'] !== 'admin' &&
        $event['id_organisateur'] != $_SESSION['user_id']
    )
) {
    header('Location: ../pages/evenement.php?supprime=unauthorized');
    exit;
}


    // Supprimer les dépendances AVANT le tournoi
    $pdo->prepare("DELETE FROM inscriptionEquipe WHERE id_evenement = ?")->execute([$idEvent]);
    $pdo->prepare("DELETE FROM matchequipe WHERE id_evenement = ?")->execute([$idEvent]);


    // Puis supprimer le tournoi
    $stmtDelete = $pdo->prepare("DELETE FROM evenement WHERE idEvenement = ?");
    $stmtDelete->execute([$idEvent]);

    header('Location: ../pages/evenement.php?supprime=ok');
    exit;
}
header('Location: ../pages/evenement.php?supprime=erreur');
exit;
