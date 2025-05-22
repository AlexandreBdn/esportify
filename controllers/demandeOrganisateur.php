<?php
require_once '../config/database.php';
session_start();

if (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("UPDATE utilisateur SET role = 'organisateur', est_valide = 0 WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);

    header('Location: ../pages/profil.php?success=organisateur');
    exit;
} else {
    header('Location: ../pages/connexion.php?erreur=acces');
    exit;
}
