<?php
session_start();
require_once '../config/database.php';

// Sécurité : vérifier que seul un admin peut accéder
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../pages/connexion.php?erreur=acces');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $id = (int) $_POST['user_id'];
      
    $stmt = $pdo->prepare("UPDATE utilisateur SET est_valide = 1 WHERE id = ?");
    $stmt->execute([$id]);
    
    // Redirection avec message de succès
    header('Location: ../pages/admin.php?success=1');
    exit;
} else {
    header('Location: ../pages/admin.php?erreur=invalide');
    exit;
}
