<?php
session_start();
require_once '../config/database.php';

// Vérifier si l'utilisateur est organisateur
// if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'organisateur') {
//     header('Location: ../pages/evenement.php');
//     exit;
// }

if (!isset($_SESSION['user_role']) || ($_SESSION['user_role'] !== 'organisateur' && $_SESSION['user_role'] !== 'admin')) {
    header('Location: ../pages/accueil.php');
    exit;
}


// Vérifier que tous les champs sont remplis
if (
    empty($_POST['titre']) ||
    empty($_POST['date_debut']) ||
    empty($_POST['date_fin']) ||
    empty($_POST['nb_joueurs_par_equipe']) ||
    empty($_POST['nb_equipes_max'])
) {
    header('Location: ../pages/creerTournoi.php?erreur=1');
    exit;
}

// Récupération des données du formulaire
$titre = $_POST['titre'];
$dateDebut = $_POST['date_debut'];
$dateFin = $_POST['date_fin'];
$nbJoueurs = (int)$_POST['nb_joueurs_par_equipe'];
$nbEquipes = (int)$_POST['nb_equipes_max'];
$idOrganisateur = $_SESSION['user_id'];

// Insertion en base de données
$requete = $pdo->prepare("
    INSERT INTO evenement (titre, date_debut, date_fin, visible, id_organisateur, nb_joueurs_par_equipe, nb_equipes_max)
    VALUES (?, ?, ?, 0, ?, ?, ?)
");

$requete->execute([
    $titre,
    $dateDebut,
    $dateFin,
    $idOrganisateur,
    $nbJoueurs,
    $nbEquipes
]);

// Redirection vers événements avec message de succès
header('Location: ../pages/evenement.php?success=creerEvent');
exit;
