<?php
session_start();
require_once '../config/database.php';

if (isset($_POST['idEquipe'], $_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $idEquipe = (int)$_POST['idEquipe'];

    // Vérifie si l'utilisateur est déjà dans une équipe
    $verif = $pdo->prepare("SELECT COUNT(*) FROM membreEquipe WHERE idUtilisateur = ?");
    $verif->execute([$userId]);
    if ($verif->fetchColumn() > 0) {
        header('Location: ../pages/profil.php?erreur=dejaEquipe');
        exit;
    }

    // Ajouter le joueur à l’équipe
    $stmt = $pdo->prepare("INSERT INTO membreEquipe (idUtilisateur, idEquipe) VALUES (?, ?)");
    $stmt->execute([$userId, $idEquipe]);

    header('Location: ../pages/profil.php?equipe=rejoint');
    exit;
}
header('Location: ../pages/profil.php?erreur=invalide');
exit;
