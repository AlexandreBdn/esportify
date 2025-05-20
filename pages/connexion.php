<?php
$page = 'connexion';
require_once '../includes/header.php';
?>
<section class="auth-container">
    <div class="auth-box login">
        <img src="../assets/images/Logo.png" alt="Esportify" class="logo" style="max-width: 100px;" />
        <h2>Connexion</h2>
        <form action="#" method="post">
            <input type="email" placeholder="Email" required>
            <input type="password" placeholder="password" required>
            <button type="submit">Connexion</button>
        </form>
        <a href="#">Mot de passe oublié ?</a>
    </div>

    <div class="auth-box register">
        <h2>Inscription</h2>
        <form action="#" method="post">
            <input type="email" placeholder="Email" required>
            <input type="text" placeholder="Nom d'utilisateur" required>
            <input type="password" placeholder="Mot de passe" required>
            <input type="password" placeholder="Confirmez le mot de passe" required>
            <input type="text" placeholder="Role" required>
            <button type="submit">Rejoins-nous</button>
        </form>
    </div>
</section>
<?php
require_once '../includes/footer.php';
?>