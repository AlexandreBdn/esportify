<?php
require_once '../includes/header.php';
require_once '../config/database.php'; // Connexion à la BDD
?>

<section class="evenements-container">
    <h2>Tous les tournois à venir</h2>

    <div class="evenements-grid">
        <?php
        $requete =$pdo->query("SELECT * FROM evenement WHERE visible = 1 ORDER BY date_debut ASC");
        $evenements = $requete->fetchAll(PDO::FETCH_ASSOC);

        foreach ($evenements as $event)
        {
            echo '<div class="event-card>';
            echo '<p><strong>Date/Heure :</strong> ' . date('d M - H\h', strtotime($event['date_debut'])) . '</p>';
            echo '<p><strong>Titre :</strong> ' . htmlspecialchars($event['titre']) . '</p>';

            // Récupérer le nombre total de joueurs déjà inscrits à cet événement
            $idEvent = $event['idEvenement'];

            $requeteJoueurs = $pdo->prepare("
            SELECT COUNT(*) AS total_joueurs
            FROM membreequipe me
            INNER JOIN inscriptionequipe ie ON me.idEquipe = ie.id_equipe
            WHERE ie.id_evenement = ?
            ");
            $requeteJoueurs->execute([$idEvent]);
            $resultJoueurs = $requeteJoueurs->fetch(PDO::FETCH_ASSOC);

            $totalJoueurs = $resultJoueurs['total_joueurs'] ?? 0;
            $maxJoueurs = $event['nb_joueurs_par_equipe'] * $event['nb_equipes_max'];

            echo '<p><strong>nb. Joueurs :</strong> ' . $totalJoueurs . ' / ' . $maxJoueurs . '</p>';


            echo '<button>Connectez-vous pour participer</button>'; // TODO : remplace selon la connexion
            echo '</div>';
        }
        ?>
    </div>
</section>

<?php require_once '../includes/footer.php'; ?>
