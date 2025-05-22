<?php
session_start();
$page = 'evenement';
date_default_timezone_set('Europe/Paris');
require_once '../includes/header.php';
require_once '../config/database.php';

// Affichage des messages d’inscription ou d’erreur
if (isset($_GET['unsubscribed']) && $_GET['unsubscribed'] == 1) {
    echo '<div class="success" style="color: orange;">Déinscription réussie.</div>';
}
if (isset($_GET['erreur']) && $_GET['erreur'] === 'incomplete') {
    echo '<div class="error" style="color: red; margin-bottom: 15px;">Votre équipe n’est pas complète. Impossible de s’inscrire.</div>';
}
if (isset($_GET['success']) && $_GET['success'] == 1) {
    echo '<div class="success" style="color: green;">Inscription réussie ! Vous êtes inscrit à l’événement.</div>';
} elseif (isset($_GET['erreur'])) {
    switch ($_GET['erreur']) {
        case 'too_many':
            echo '<div class="error" style="color: red;">Votre équipe contient trop de joueurs pour ce format.</div>';
            break;
        case 'insert_failed':
            echo '<div class="error" style="color: red;">Une erreur est survenue lors de l’inscription.</div>';
            break;
        case 'no_team':
            echo '<div class="error" style="color: red;">Vous n’avez pas d’équipe. Créez-en une avant de vous inscrire.</div>';
            break;
    }
}
?>
<?php if (isset($_GET['success']) && $_GET['success'] === 'start') : ?>
    <div class="success" style="color: green; margin-bottom: 15px;">
        L’événement a bien été démarré.
    </div>
<?php endif; ?>

<?php if (isset($_GET['success']) && $_GET['success'] === 'creerEvent') : ?>
    <div class="success" style="color: orange; margin-bottom: 15px;">
        L'evenement est en cour de validation !
    </div>
<?php endif; ?>

<?php if (isset($_GET['supprime']) && $_GET['supprime'] === 'ok') : ?>
    <div class="success" style="color: green;">Tournoi supprimé avec succès ✅</div>
<?php elseif (isset($_GET['supprime']) && $_GET['supprime'] === 'erreur') : ?>
    <div class="error" style="color: red;">❌ Impossible de supprimer ce tournoi.</div>
<?php endif; ?>




<section class="evenements-container">
    <h2>Tous les tournois à venir</h2>

    <div class="evenements-grid">
        <?php
        $requete = $pdo->query("SELECT * FROM evenement WHERE visible = 1 ORDER BY date_debut ASC");
        $evenements = $requete->fetchAll(PDO::FETCH_ASSOC);

        foreach ($evenements as $event) {
          
            echo "<div class='event-card'>";
            echo "<p><strong>Titre :</strong> " . htmlspecialchars($event['titre']) . "</p>";
           


            $nbParEquipe = $event['nb_joueurs_par_equipe'];
            echo "<p><strong>format :</strong> " . $nbParEquipe . " vs " . $nbParEquipe . "</p>";

            echo "<p><strong>Date/Heure :</strong> " . date('d M - H\h', strtotime($event['date_debut'])) . "</p>";

            // Nb joueurs inscrits
            $idEvent = $event['idEvenement'];

            $requeteJoueurs = $pdo->prepare("SELECT COUNT(*) AS total_joueurs
                FROM membreEquipe me
                INNER JOIN inscriptionEquipe ie ON me.idEquipe = ie.id_equipe
                WHERE ie.id_evenement = ?");
            $requeteJoueurs->execute([$idEvent]);
            $resultJoueurs = $requeteJoueurs->fetch(PDO::FETCH_ASSOC);
            $totalJoueurs = $resultJoueurs['total_joueurs'] ?? 0;
            $maxJoueurs = $event['nb_joueurs_par_equipe'] * $event['nb_equipes_max'];

            echo "<p><strong>nb. Joueurs :</strong> $totalJoueurs / $maxJoueurs</p>";

            // --- Affichage du bouton ---
            if (isset($_SESSION['user_id'])) {
                $userId = $_SESSION['user_id'];

                $requeteInscription = $pdo->prepare("SELECT COUNT(*) AS deja_inscrit
                    FROM utilisateur
                    INNER JOIN membreEquipe me ON utilisateur.id = me.idUtilisateur
                    INNER JOIN inscriptionEquipe ie ON me.idEquipe = ie.id_equipe
                    WHERE utilisateur.id = ? AND ie.id_evenement = ?");
                $requeteInscription->execute([$userId, $idEvent]);
                $dejaInscrit = $requeteInscription->fetch()['deja_inscrit'] ?? 0;

                $requeteInfos = $pdo->prepare("SELECT est_commence, date_debut, id_organisateur FROM evenement WHERE idEvenement = ?");
                $requeteInfos->execute([$idEvent]);
                $eventInfos = $requeteInfos->fetch(PDO::FETCH_ASSOC);

                $idOrganisateur = $eventInfos['id_organisateur'];
                $estLance = $eventInfos['est_commence'];
                $dateDebut = strtotime($eventInfos['date_debut']);
                $maintenant = time();
                

                if ($_SESSION['user_id'] == $idOrganisateur && !$estLance && $dateDebut - $maintenant <= 1800 && $dateDebut - $maintenant >= 0) {
                    echo '<form action="../controllers/demarrerEvenement.php" method="post">';
                    echo '<input type="hidden" name="event_id" value="' . $idEvent . '">';
                    echo '<button type="submit" class="btn-participer">Démarrer l\'événement</button>';
                    echo '</form>';
                }
                if ($userId == $idOrganisateur) {
                    echo '<button disabled class="btn-participer">Organisateur</button>';
                } elseif ($dejaInscrit > 0) {
                    if ($estLance) {
                        echo '<a href="tournoi.php?id=' . $idEvent . '" class="btn-participer">Rejoindre</a>';
                    } else {
                    //  L'utilisateur est déjà inscrit → bouton de désinscription
                        echo '
                        <form action="../controllers/participationController.php" method="post">
                            <input type="hidden" name="event_id" value="' . $idEvent . '">
                            <input type="hidden" name="action" value="unsuscribe">
                            <button type="submit" class="btn-participer">Se désinscrire</button>
                        </form>';
                    }
                } elseif ($totalJoueurs >= $maxJoueurs) {
                    echo '<button disabled class="btn-participer">Tournoi complet</button>';
                } else {
                    echo '<form action="../controllers/participationController.php" method="post">
                        <input type="hidden" name="event_id" value="' . $idEvent . '">
                        <button type="submit" class="btn-participer">Participer</button>
                    </form>';
                }
            } else {
                echo '<button disabled class="btn-participer">Connectez-vous pour participer</button>';
            }

            // Vérifie si l'utilisateur peut supprimer

            if (
    isset($_SESSION['user_id'], $_SESSION['user_role']) &&
    (
        ($_SESSION['user_id'] == $idOrganisateur && isset($dateDebut, $maintenant) && $maintenant - $dateDebut > 3600)
        || ($_SESSION['user_role'] === 'admin' && isset($dateDebut, $maintenant) && $maintenant - $dateDebut > 3600)
    )
) {
    // Affiche le bouton Supprimer
    echo '<form action="../controllers/supprimerTournoiController.php" method="post" style="margin-top: 10px;">';
      echo '<input type="hidden" name="id_tournoi" value="' . $idEvent . '">';
      echo '<button type="submit" class="btn-participer" onclick="return confirm(\'Supprimer ce tournoi ?\')">🗑 Supprimer</button>';
      echo '</form>';
}
            echo "</div>";
            

            
        }
        ?>
    </div>
        <?php 
        if ((isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'organisateur') || (($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin')) : ?>
        <div class="create-tournament">
            <a href="../pages/creerTournoi.php" class="btn-participer lien">Créer un tournoi</a>

        </div>
        <?php endif; ?>

</section>

<?php require_once '../includes/footer.php'; ?>
