<?php
$page = 'connexion';
require_once '../includes/header.php';
?>

<?php if (isset($_GET['success']) && $_GET['success'] == 1) : ?>
    <div class="success" style="color: green; margin-bottom: 15px;">
        Inscription réussie ! Vous pouvez maintenant vous connecter.
    </div>
<?php endif; ?>

<?php if (isset($_GET['erreur']) && $_GET['erreur'] === 'acces'): ?>
    <div class="erreur" style="color: red;">Accès non autorisé.</div>
<?php endif; ?>

<?php if (isset($_GET['erreur'])) : ?>
    <div class="erreur" style="color: red; margin-bottom: 15px;">
        <?php
            switch ($_GET['erreur']) {
                case 'email':
                    echo "Email invalide.";
                    break;
                case 'mdp':
                    echo "Les mots de passe ne correspondent pas.";
                    break;
                case 'longueur':
                    echo "Mot de passe trop court.";
                    break;
                default:
                    echo "Erreur lors de l'inscription.";
            }
        ?>
    </div>
<?php endif; ?>

<?php if (isset($_GET['erreur']) && $_GET['erreur'] === 'existant') : ?>
    <div class="erreur" style="color: red; margin-bottom: 15px;">
        Cet email est déjà utilisé.
    </div>
<?php endif; ?>


<section class="auth-container">
    <div class="auth-box login">
        <img src="../assets/images/Logo.png" alt="Esportify" class="logo" style="max-width: 100px;" />
        <h2>Connexion</h2>
        <form action="../controllers/connexionController.php" method="post">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="password" required>
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
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="nom" placeholder="Nom d'utilisateur" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <input type="password" name="confirm_password" placeholder="Confirmez le mot de passe" required>
            <button type="submit">Rejoins-nous</button>
        </form>
    </div>
</section>
<?php
require_once '../includes/footer.php';
?>