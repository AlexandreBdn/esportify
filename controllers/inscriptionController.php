<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'], $_POST['nom'], $_POST['password'], $_POST['confirm_password'])) {
    $email = trim($_POST['email']);
    $nom = trim($_POST['nom']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
   
    $role = 'joueur';

    // Vérification basique
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreur = "Email invalide.";
    } elseif ($password !== $confirm_password) {
        $erreur = "Les mots de passe ne correspondent pas.";
    } elseif (strlen($password) < 6) {
        $erreur = "Mot de passe trop court.";
    } else {
        require_once '../config/database.php';
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO utilisateur (nom, email, mot_de_passe, role) VALUES (?, ?, ?, ?)");
        $success = $stmt->execute([$nom, $email, $hash, $role]);

        if ($success) {
            header("Location: connexion.php?success=1");
            exit;
        } else {
            $erreur = "Erreur lors de l'inscription.";
        }
    }
}
?>
