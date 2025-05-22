<?php
session_start();
$page = 'equipe';
require_once '../config/database.php';

// Vérifie qu'on est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit;
}

// Vérifie si le joueur est déjà dans une équipe
$verif = $pdo->prepare("SELECT COUNT(*) FROM membreEquipe WHERE idUtilisateur = ?");
$verif->execute([$_SESSION['user_id']]);
if ($verif->fetchColumn() > 0) {
    header('Location: profil.php?erreur=dejaEquipe');
    exit;
}

// Récupère les équipes disponibles
$equipes = $pdo->query("SELECT idEquipe, nom FROM equipe")->fetchAll();
?>
<main>
    <h2>Rejoindre une équipe</h2>
    <div class="equipe-container">
        <?php foreach ($equipes as $equipe) : ?>
            <div class="equipe-card">
                <form action="../controllers/rejoindreEquipeController.php" method="post">
                    <input type="hidden" name="idEquipe" value="<?= $equipe['idEquipe'] ?>">
                    <p><?= htmlspecialchars($equipe['nom']) ?></p>
                    <button type="submit">Rejoindre</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</main>
