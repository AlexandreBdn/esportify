<?php
session_start();
$page = 'profil';
require_once '../includes/header.php';
require_once '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php?erreur=acces');
    exit;
}
?>

<section class="profil-container">
    <div class="card-turquoise">
    <h2>Mon profil</h2>

    <p><strong>Nom :</strong> <?= htmlspecialchars($_SESSION['user_nom']) ?></p>
    <p><strong>Rôle :</strong> <?= htmlspecialchars($_SESSION['user_role']) ?></p>
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

<?php require_once '../includes/footer.php'; ?>
