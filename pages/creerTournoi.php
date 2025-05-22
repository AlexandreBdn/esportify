<?php
session_start();
$page ='creationTournoi';
require_once '../config/database.php';
require_once '../includes/header.php';


// Redirection si l'utilisateur n'est pas organisateur
if (!isset($_SESSION['user_role']) || ($_SESSION['user_role'] !== 'organisateur' && $_SESSION['user_role'] !== 'admin')) {
    header('Location: ../pages/accueil.php');
    exit;
}


?>
<main class="container">
    <h2>Créer un nouveau tournoi</h2>

    <form action="../controllers/creerTournoiController.php" method="post">
        <label for="titre">Titre du tournoi :</label>
        <input type="text" id="titre" name="titre" required>

        <label for="date_debut">Date et heure de début :</label>
        <input type="datetime-local" id="date_debut" name="date_debut" required>

        <label for="date_fin">Date et heure de fin :</label>
        <input type="datetime-local" id="date_fin" name="date_fin" required>

        <label for="nb_joueurs_par_equipe">Nombre de joueurs par équipe :</label>
        <input type="number" id="nb_joueurs_par_equipe" name="nb_joueurs_par_equipe" min="1" required>

        <label for="nb_equipes_max">Nombre d'équipes maximum :</label>
        <input type="number" id="nb_equipes_max" name="nb_equipes_max" min="2" required>

        <button type="submit" class="btn-participer">Créer le tournoi</button>
    </form>
</main>

<?php require_once '../includes/footer.php'; ?>
