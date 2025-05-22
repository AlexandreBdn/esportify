<?php
require_once '../config/database.php';
session_start();

if ($_SESSION['user_role'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_tournoi'], $_POST['action'])) {
    $id = (int) $_POST['id_tournoi'];
    $action = $_POST['action'];

    if ($action === 'valider') {
        $stmt = $pdo->prepare("UPDATE evenement SET visible = 1 WHERE idEvenement = ?");
        $stmt->execute([$id]);
    } elseif ($action === 'refuser') {
        // Soit on supprime, soit on garde et masque définitivement (visible = -1)
        $stmt = $pdo->prepare("DELETE FROM evenement WHERE idEvenement = ?");
        $stmt->execute([$id]);
    }
}

header('Location: ../admin.php');
exit;

