<?php
$page = 'connexion';
require_once '../includes/header.php';
?>

<?php if (isset($_GET['success']) && $_GET['success'] == 1) : ?>
    <div class="success" style="color: green; margin-bottom: 15px;">
        Inscription réussie ! Vous pouvez maintenant vous connecter.
    </div>
<?php endif; ?>

<?php if (isset($_GET['erreur']) && $_GET['erreur'] == 1): ?>
    <div class="erreur" style="color: red; margin-bottom: 15px;">
        Identifiants invalides.
    </div>
<?php endif; ?>

<section class="auth-container">
    <div class="auth-box login">
        <img src="../assets/images/Logo.png" alt="Esportify" class="logo" style="max-width: 100px;" />
        <h2>Connexion</h2>
        <form action="../controllers/connexionController.php" method="post">
            <input type="email" placeholder="Email" required>
            <input type="password" placeholder="password" required>
            <button type="submit">Connexion</button>
        </form>
        <a href="#">Mot de passe oublié ?</a>
    </div>

    <?php if (isset($erreur)) : ?>
    <div class="erreur" style="color: red; margin-bottom: 15px;">
        <?= htmlspecialchars($erreur) ?>
    </div>
    <?php endif; ?>

    <div class="auth-box register">
        <h2>Inscription</h2>
        <form action="../controllers/inscriptionController.php" method="post">
            <input type="email" placeholder="Email" required>
            <input type="text" placeholder="Nom d'utilisateur" required>
            <input type="password" placeholder="Mot de passe" required>
            <input type="password" placeholder="Confirmez le mot de passe" required>
            <button type="submit">Rejoins-nous</button>
        </form>
    </div>
</section>
<?php
require_once '../includes/footer.php';
?>