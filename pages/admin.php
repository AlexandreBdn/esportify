<?php
session_start();
$page = 'profil';
require_once '../includes/header.php';
require_once '../config/database.php';

if (isset($_GET['success'])) : ?>
    <div style="color: green;">Compte validé avec succès !</div>
<?php endif;


// Vérifie que l'utilisateur est un admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: connexion.php?erreur=acces');
    exit;
}
?>

<h2>Comptes organisateurs à valider</h2>

<?php
$requete = $pdo->query("SELECT * FROM Utilisateur WHERE role = 'organisateur' AND est_valide = 0");
$organisateurs = $requete->fetchAll(PDO::FETCH_ASSOC);

if (count($organisateurs) === 0) {
    echo "<p>Aucun compte à valider.</p>";
} else {
    echo "<ul>";
    foreach ($organisateurs as $orga) {
        echo "<li>";
        echo htmlspecialchars($orga['nom']) . " (" . htmlspecialchars($orga['email']) . ")";
        echo '
            <form action="../controllers/validerCompte.php" method="post" style="display:inline;">
                <input type="hidden" name="user_id" value="' . $orga['id'] . '">
                <button type="submit" name="action" value="valider">✅ Valider</button>
                <button type="submit" name="action" value="refuser" onclick="return confirm( Êtes-vous sûr de vouloir refuser ce tournoi ?)">❌ Refuser</button>
            </form>
        ';
        echo "</li>";
    }
    echo "</ul>";
}

$requeteTournois = $pdo->query("SELECT * FROM evenement WHERE visible = 0");
$tournoisAttente = $requeteTournois->fetchAll(PDO::FETCH_ASSOC);?>

    <h2>Tournois en attente de validation</h2>
<?php if (count($tournoisAttente) > 0): ?>
    <ul>
        <?php foreach ($tournoisAttente as $tournoi): ?>
            <li>
                <?= htmlspecialchars($tournoi['titre']) ?> - <?= date('d M Y H:i', strtotime($tournoi['date_debut'])) ?>
                <form action="../controllers/validerTournoi.php" method="post" style="display:inline;">
                    <input type="hidden" name="id_tournoi" value="<?= $tournoi['idEvenement'] ?>">
                    <button type="submit" name="action" value="valider">✅ Valider</button>
                    <button type="submit" name="action" value="refuser" onclick="return confirm('Êtes-vous sûr de vouloir refuser ce tournoi ?')">❌ Refuser</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Aucun tournoi en attente.</p>
<?php endif; ?>

<?php require_once '../includes/footer.php'; ?>
