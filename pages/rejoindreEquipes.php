<?php
session_start();
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

<h2>Rejoindre une équipe</h2>

<?php foreach ($equipes as $equipe): ?>
    <form action="../controllers/rejoindreEquipeController.php" method="post" style="display:inline;">
        <input type="hidden" name="idEquipe" value="<?= $equipe['idEquipe'] ?>">
        <button type="submit"><?= htmlspecialchars($equipe['nom']) ?> — Rejoindre</button>
    </form>
<?php endforeach; ?>
