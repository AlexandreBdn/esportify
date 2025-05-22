<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Contact - Esportify</title>
    <link rel="stylesheet" href="../assets/css/contact.css">
</head>
<body>

<?php require_once '../includes/header.php'; ?>

<div class="contact-container">
    <h2>Contactez-nous</h2>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nom = htmlspecialchars($_POST['nom'] ?? '');
        $email = htmlspecialchars($_POST['email'] ?? '');
        $message = htmlspecialchars($_POST['message'] ?? '');

        if (!empty($nom) && !empty($email) && !empty($message)) {
            echo "<p style='color: green;'>Merci pour votre message, $nom. Nous reviendrons vers vous rapidement !</p>";
        } else {
            echo "<p style='color: red;'>Veuillez remplir tous les champs.</p>";
        }
    }
    ?>

    <form method="POST" action="contact.php" style="display: flex; flex-direction: column; gap: 10px;">
        <label>Nom :
            <input type="text" name="nom" required>
        </label>
        <label>Email :
            <input type="email" name="email" required>
        </label>
        <label>Message :
            <textarea name="message" rows="5" required></textarea>
        </label>
        <button type="submit">Envoyer</button>
    </form>
</div>

<?php require_once '../includes/footer.php'; ?>

</body>
</html>
