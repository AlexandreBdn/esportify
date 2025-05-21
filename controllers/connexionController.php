<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'], $_POST['password'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    require_once '../config/database.php';

    $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['mot_de_passe'])) {
        // Connexion réussie : on stocke les infos utiles en session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_nom'] = $user['nom'];
        $_SESSION['user_role'] = $user['role'];

        // Redirection vers la page d'accueil
        header('Location: ../index.php');
        exit;
    } else {
        // Redirection avec erreur
        header('Location: ../pages/connexion.php?erreur=1');
        exit;
    }
} else {
    // Accès direct non autorisé
    header('Location: ../pages/connexion.php');
    exit;
}
