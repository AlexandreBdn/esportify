<?php
session_start();
$page = 'evenement';
require_once '../includes/header.php';
require_once '../config/database.php'; // Connexion à la BDD

if (isset($_GET['unsuscribed']) && $_GET['unsuscribed'] == 1) {
    echo '<div class="success" style="color: orange;">Désinscription réussie.</div>';
}


?>

<?php if (isset($_GET['erreur']) && $_GET['erreur'] === 'incomplete') : ?>
    <div class="error" style="color: red; margin-bottom: 15px;">
        Votre équipe n'est pas complète. Impossible de s'inscrire.
    </div>
<?php endif; ?>

<?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
    <div class="success-message">Inscription réussie !</div>
<?php endif; ?>

<?php
if (isset($_GET['success']) && $_GET['success'] == 1) {
    echo '<div class="success" style="color: green;">Inscription réussie ! Vous êtes inscrit à l’événement.</div>';
} elseif (isset($_GET['error']) && $_GET['error'] === 'incomplete') {
    echo '<div class="error" style="color: red;">Votre équipe n’est pas complète. Impossible de s’inscrire.</div>';
} elseif (isset($_GET['error']) && $_GET['error'] === 'insert_failed') {
    echo '<div class="error" style="color: red;">Une erreur est survenue lors de l’inscription. Veuillez réessayer.</div>';
}
elseif (isset($_GET['error']) && $_GET['error'] === 'no_team') {
    echo '<div class="error" style="color: red;">Vous n\'avez pas d\'équipe. Créez-en une avant de vous inscrire.</div>';
}

?>


<section class="evenements-container">
    <h2>Tous les tournois à venir</h2>

    <div class="evenements-grid">
        <?php
        $requete =$pdo->query("SELECT * FROM evenement WHERE visible = 1 ORDER BY date_debut ASC");
        $evenements = $requete->fetchAll(PDO::FETCH_ASSOC);

        foreach ($evenements as $event)
        {
            echo "<div class='event-card'>";
            echo "<p><strong>Date/Heure :</strong> " . date('d M - H\h', strtotime($event['date_debut'])) . "</p>";
            echo "<p><strong>Titre :</strong> " . htmlspecialchars($event['titre']) . "</p>";

            // Récupérer le nombre total de joueurs déjà inscrits à cet événement
            $idEvent = $event['idEvenement'];

            $requeteJoueurs = $pdo->prepare("
             SELECT COUNT(*) AS total_joueurs
             FROM membreEquipe me
             INNER JOIN inscriptionEquipe ie ON me.idEquipe = ie.id_equipe
             AND ie.id_evenement = ?
            ");
            $requeteJoueurs->execute([$idEvent]);

            $resultJoueurs = $requeteJoueurs->fetch(PDO::FETCH_ASSOC);

            $totalJoueurs = $resultJoueurs['total_joueurs'] ?? 0;
            $maxJoueurs = $event['nb_joueurs_par_equipe'] * $event['nb_equipes_max'];

            echo '<p><strong>nb. Joueurs :</strong> ' . $totalJoueurs . ' / ' . $maxJoueurs . '</p>';

if (isset($_SESSION['user_id'])) {
    // Vérifie si l'utilisateur est déjà inscrit
    $requeteInscription = $pdo->prepare("
        SELECT COUNT(*) AS deja_inscrit
        FROM utilisateur
        INNER JOIN membreEquipe me ON utilisateur.id = me.idUtilisateur
        INNER JOIN inscriptionEquipe ie ON me.idEquipe = ie.id_equipe
        WHERE utilisateur.id = ? AND ie.id_evenement = ?
    ");
    $requeteInscription->execute([$_SESSION['user_id'], $idEvent]);
    $dejaInscrit = $requeteInscription->fetch()['deja_inscrit'] ?? 0;

    if ($dejaInscrit > 0) {
        //  L'utilisateur est déjà inscrit → bouton de désinscription
        echo '
        <form action="../controllers/participationController.php" method="post">
            <input type="hidden" name="event_id" value="' . $idEvent . '">
            <input type="hidden" name="action" value="unsuscribe">
            <button type="submit" class="btn-participer">Se désinscrire</button>
        </form>';
    } elseif ($totalJoueurs >= $maxJoueurs) {
        //  Tournoi complet et l'utilisateur n'est pas inscrit
        echo '<button disabled>Tournoi complet</button>';
    } else {
        //  Tournoi disponible → bouton d'inscription
        echo '
        <form action="../controllers/participationController.php" method="post">
            <input type="hidden" name="event_id" value="' . $idEvent . '">
            <button type="submit" class="btn-participer">Participer</button>
        </form>';
    }
} else {
    //  Utilisateur non connecté
    echo '<button disabled>Connectez-vous pour participer</button>';
}

    echo "</div>";
    }
        ?>
    </div>
</section>

<?php require_once '../includes/footer.php'; ?>
