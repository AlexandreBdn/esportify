<?php if (isset($page) && $page === 'connexion') : ?>
  <link rel="stylesheet" href="/assets/css/connexion.css">
<?php endif; ?>
<?php if (isset($page) && $page === 'evenement') : ?>
  <link rel="stylesheet" href="/assets/css/evenement.css">
<?php endif; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Esportify</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <a href="../index.php">
                    <img src="/assets/images/logo.png" alt="Esportify" height="40">
                </a>
                <span>Esportify</span>
            </div>
            <ul class="nav-links">
                <li><a href="../index.php">Accueil</a></li>
                <li><a href="../pages/evenement.php">Evenements</a></li>
                <li><a href="../pages/contact.php">Contact</a></li>
            </ul>
            <div class="auth-actions">
                <?php if (isset($_SESSION['user_id'])):?>
                <div class="user-badge">
                    <span class="initial"><?php echo strtoupper(substr($_SESSION['user_nom'],0,1)); ?></span>
                    <div class="nav-buttons">
                        <a href="../controllers/logout.php" class="btn">Deconnexion</a>
                    </div>
                </div>
                <?php else: ?>
                <div class="nav-buttons">
                    <a href="../pages/connexion.php" class="btn">Connexion / Inscription</a>
                </div>
                    <?php endif; ?>
            </div>
        </nav>
    </header>