
<?php require_once './config/database.php'; ?>
<?php
$requete = $pdo->query("SELECT * FROM evenement WHERE visible = 1 ORDER BY date_debut ASC");
$evenements = $requete->fetchAll(PDO::FETCH_ASSOC);
?>
<section class="hero">
    <div class="container">
        <h1>Bienvenue sur Esportify</h1>
        <p>Participez a des tournois e-sport palpitants, affrontez des joueurs du monde entier , devenez le meilleur, et suivez vos performance ! </p><br>
        <p>🎮 Esportify est une plateforme dynamique dédiée à l’univers de l’e-sport amateur et semi-professionnel. Notre mission ? Offrir un espace simple 
          et intuitif où les passionnés peuvent organiser, rejoindre et suivre des tournois compétitifs en ligne dans une variété de jeux populaires. Que vous soyez joueur, 
          organisateur ou spectateur, Esportify vous connecte à une communauté grandissante de challengers motivés, le tout dans une interface moderne et conviviale. Préparez 
          votre équipe, affrontez les meilleurs et faites briller votre nom dans l’arène numérique !</p>
    </div>
</section>

<section class="gallery">
    <div class="container">
        <h2>Galerie</h2>
        <div class="gallery-grid">
            <img src="../assets/images/galerie1.jpg" alt="Evenement 1">
            <img src="../assets/images/galerie2.jpg" alt="Evenement 2">
            <img src="../assets/images/galerie3.jpg" alt="Evenement 3">
            <img src="../assets/images/galerie4.jpg" alt="Evenement 4">
        </div>
    </div>
</section>

<?php $compteur = 0; ?>
<section class="evenements">
    <div class="container">
        <h2>Evenements a venir</h2> 
        <div class="event-grid">
            <?php foreach ($evenements as $event): 
                if ($compteur >= 6) {
                    break; // Arrête la boucle après 6 événement
                }?>
                <div class="event-card">
            <p><strong>Date/Heure :</strong> <?= date('d M - H\h', strtotime($event['date_debut'])) ?></p>
            <p><strong>Titre :</strong> <?= htmlspecialchars($event['titre']) ?></p>
            <p><strong>nb. Joueur :</strong> 
        <?php
          // Compte les joueurs inscrits
          $idEvent = $event['idEvenement'];
          $stmt = $pdo->prepare("
            SELECT COUNT(*) AS total_joueurs
            FROM membreEquipe me
            INNER JOIN inscriptionEquipe ie ON me.idEquipe = ie.id_equipe
            WHERE ie.id_evenement = ?
          ");
        $stmt->execute([$idEvent]);
        $nbJoueurs = $stmt->fetch()['total_joueurs'] ?? 0;
        $nbParEquipe = $event['nb_joueurs_par_equipe'] ?? 0;
        $nbEquipes   = $event['nb_equipes_max'] ?? 0;
        $nbMaxJoueurs = $nbParEquipe * $nbEquipes;

        echo $nbJoueurs . ' / ' . $event['nb_joueurs_par_equipe'] * $event['nb_equipes_max'];

        ?>
      </p>

      <?php if (isset($_SESSION['user_id'])): ?>
        <form action="pages/evenement.php" method="get">
          <button type="submit">Voir les événements</button>
        </form>
      <?php else: ?>
        <button class="btn-disabled" disabled>Connectez-vous pour participer</button>
        <?php $compteur++; ?>
      <?php endif; ?>
    </div>
    <?php endforeach; ?>
</div>
</div>

    </div>
</section>