

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'], $_POST['nom'], $_POST['password'], $_POST['confirm_password'])) {
    $email = trim($_POST['email']);
    $nom = trim($_POST['nom']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
   
    $role = 'joueur';

    // Vérification basique
   if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../pages/connexion.php?erreur=email");
        exit;
    }   elseif ($password !== $confirm_password) {
            header("Location: ../pages/connexion.php?erreur=mdp");
            exit;
    }   elseif (strlen($password) < 6) {
            header("Location: ../pages/connexion.php?erreur=longueur");
            exit;
    } else {
        require_once '../config/database.php';
        $hash = password_hash($password, PASSWORD_DEFAULT);


        // Vérifie si l'email est déjà utilisé
    $checkStmt = $pdo->prepare("SELECT id FROM utilisateur WHERE email = ?");
    $checkStmt->execute([$email]);
    if ($checkStmt->fetch()) {
        header("Location: ../pages/connexion.php?erreur=existant");
        exit;
    }


        $stmt = $pdo->prepare("INSERT INTO utilisateur (nom, email, mot_de_passe, role) VALUES (?, ?, ?, ?)");
        $success = $stmt->execute([$nom, $email, $hash, $role]);

        if ($success) {
            header("Location: ../pages/connexion.php?success=1");
            exit;
        } else {
            $erreur = "Erreur lors de l'inscription.";
            header("Location: ../pages/connexion.php?erreur=1");
            exit;
        }
    }
}
?>
