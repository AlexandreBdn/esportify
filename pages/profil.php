<?php
session_start();
$page = 'profil';
require_once '../includes/header.php';
require_once '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php?erreur=acces');
    exit;
}

// Récupérer le nom de l'équipe de l'utilisateur
$requeteEquipe = $pdo->prepare("
    SELECT e.nom 
    FROM membreEquipe me
    JOIN equipe e ON me.idEquipe = e.idEquipe
    WHERE me.idUtilisateur = ?
");
$requeteEquipe->execute([$_SESSION['user_id']]);
$equipeNom = $requeteEquipe->fetchColumn();


?>
<?php 
    if (isset($_GET['quitte'])): ?>
    <div class="success" style="color: red;">Tu as quitté ton équipe avec succès.</div>
<?php endif; ?>

<section class="profil-container">
    <div class="card-turquoise">
    <h2>Mon profil</h2>
    <p><strong>Nom :</strong> <?= htmlspecialchars($_SESSION['user_nom']) ?></p>
    <p><strong>Rôle :</strong> <?= htmlspecialchars($_SESSION['user_role']) ?></p>
    <p><strong>Équipe :</strong>
    <?php if ($equipeNom): ?>
        <?= htmlspecialchars($equipeNom) ?>
        <form action="../controllers/quitterEquipeController.php" method="post" style="display:inline;">
            <button type="submit" class="btn-small" onclick="return confirm('Es-tu sûr de vouloir quitter l’équipe ?')">
                ❌ Quitter
            </button>
        </form>
    <?php else: ?>
        Sans équipe
    <?php endif; ?>
</p>

    </div>

    <?php if (isset($_GET['success']) && $_GET['success'] === 'organisateur') : ?>
        <div class="success" style="color: green; margin-bottom: 15px;">
            Votre demande pour devenir organisateur a bien été envoyée. Elle est en attente de validation.
        </div>
    <?php endif; ?>

    <?php if ($_SESSION['user_role'] === 'joueur') : ?>
        <form action="../controllers/demandeOrganisateur.php" method="post">
            <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
            <button type="submit" class="btn">Demander à devenir organisateur</button>
        </form>
    <?php endif; ?>
</section>

<?php if (!isset($userEquipe)) : ?>
    <a href="../pages/creerEquipe.php" class="btn-participer">Créer une équipe</a>
<?php endif; ?>


<?php
// Vérifie s’il a déjà une équipe
$verif = $pdo->prepare("SELECT COUNT(*) FROM membreEquipe WHERE idUtilisateur = ?");
$verif->execute([$_SESSION['user_id']]);
if ($verif->fetchColumn() == 0): ?>
    <a href="../pages/rejoindreEquipes.php" class="btn-participer">Rejoindre une équipe</a>
<?php endif; ?>


<?php require_once '../includes/footer.php'; ?>
