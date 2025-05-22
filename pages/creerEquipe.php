<?php
session_start();
$page = 'creationEquipe';
require_once '../includes/header.php';

if (isset($_GET['erreur'])) {
    if ($_GET['erreur'] === 'nomcourt') {
        echo "<p style='color:red;'>❌ Le nom de l’équipe doit faire au moins 3 caractères.</p>";
    } elseif ($_GET['erreur'] === 'existe') {
        echo "<p style='color:red;'>❌ Ce nom d’équipe existe déjà.</p>";
    } elseif ($_GET['erreur'] === 'dejaEquipe') {
        echo "<p style='color:red;'>❌ Vous faites déjà partie d’une équipe.</p>";
    }
}
?>

<form action="../controllers/creerEquipeController.php" method="post">
    <label for="nom">Nom de l’équipe :</label>
    <input type="text" name="nom" required>
    <button type="submit">Créer</button>
</form>

<?php require_once '../includes/footer.php'; ?>
