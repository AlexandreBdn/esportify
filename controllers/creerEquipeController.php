<?php
session_start();
require_once '../config/database.php';

if (isset($_POST['nom'], $_SESSION['user_id'])) {
    $nom = trim($_POST['nom']);
    $userId = $_SESSION['user_id'];

    // Vérifie que le nom est assez long
    if (strlen($nom) < 3) {
        header('Location: ../pages/creerEquipe.php?erreur=nomcourt');
        exit;
    }

    // Vérifie si l’utilisateur est déjà dans une équipe
    $verif = $pdo->prepare("SELECT COUNT(*) FROM membreEquipe WHERE idUtilisateur = ?");
    $verif->execute([$userId]);

    if ($verif->fetchColumn() > 0) {
        header('Location: ../pages/creerEquipe.php?erreur=dejaEquipe');
        exit;
    }

    try {
        // Crée l’équipe
        $stmt = $pdo->prepare("INSERT INTO equipe (nom) VALUES (?)");
        $stmt->execute([$nom]);
        $idEquipe = $pdo->lastInsertId();

        // Ajoute l’utilisateur dans l’équipe
        $stmt2 = $pdo->prepare("INSERT INTO membreEquipe (idUtilisateur, idEquipe) VALUES (?, ?)");
        $stmt2->execute([$userId, $idEquipe]);

        header('Location: ../pages/creerEquipe.php?erreur=cree');
        exit;

    } catch (PDOException $e) {
        if ($e->errorInfo[1] == 1062) {
            header('Location: ../pages/creerEquipe.php?erreur=existe');
            exit;
        } else {
            throw $e;
        }
    }
}
?>

