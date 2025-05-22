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
                <button type="submit">Valider</button>
            </form>
        ';
        echo "</li>";
    }
    echo "</ul>";
}
?>

<?php require_once '../includes/footer.php'; ?>
