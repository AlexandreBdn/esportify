<?php
session_start();
require_once '../config/database.php';

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Supprime l'utilisateur de son équipe
    $stmt = $pdo->prepare("DELETE FROM membreEquipe WHERE idUtilisateur = ?");
    $stmt->execute([$userId]);

    header('Location: ../pages/profil.php?quitte=1');
    exit;
} else {
    header('Location: ../pages/connexion.php?erreur=non-connecte');
    exit;
}
