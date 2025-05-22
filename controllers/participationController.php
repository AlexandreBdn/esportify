<?php
session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['event_id'], $_SESSION['user_id'])) {
    $idEvent = intval($_POST['event_id']);
    $action = $_POST['action'] ?? 'subscribe';
    $idMembre = $_SESSION['user_id'];

    // 1. Récupérer l'équipe du membre
    $stmtEquipe = $pdo->prepare("SELECT idEquipe FROM membreEquipe WHERE idUtilisateur = ?");
    $stmtEquipe->execute([$idMembre]);
    $equipe = $stmtEquipe->fetch();

    if (!$equipe) {
    header('Location: ../pages/evenement.php?error=no_team');
    exit;
    }


    if ($equipe) {
        $idEquipe = $equipe['idEquipe'];
        // Vérifier que l'équipe a bien le bon nombre de joueurs
        $stmtCount = $pdo->prepare("SELECT COUNT(*) FROM Membreequipe WHERE idEquipe = ?");
        $stmtCount->execute([$idEquipe]);
        $nbJoueursEquipe = $stmtCount->fetchColumn();

        // Récupérer le nombre requis par équipe pour l'événement
        $stmtRequis = $pdo->prepare("SELECT nb_joueurs_par_equipe FROM evenement WHERE idEvenement = ?");
        $stmtRequis->execute([$idEvent]);
        $nbRequis = $stmtRequis->fetchColumn();

    }
    if ($nbJoueursEquipe < $nbRequis) {
    header('Location: ../pages/evenement.php?erreur=incomplete');
    exit;
    }
    if ($nbJoueursEquipe > $nbRequis) {
    header('Location: ../pages/evenement.php?erreur=too_many');
    exit;
}

    if ($action === 'unsuscribe') {
        $stmtDelete = $pdo->prepare("DELETE FROM inscriptionequipe WHERE id_evenement = ? AND id_equipe = ?");
        $stmtDelete->execute([$idEvent, $idEquipe]);
        header('Location: ../pages/evenement.php?unsuscribed=1');
        exit;
    }


        // 2. Vérifier si l'inscription existe déjà (sécurité)
        $stmtCheck = $pdo->prepare("SELECT COUNT(*) FROM inscriptionequipe WHERE id_evenement = ? AND id_equipe = ?");
        $stmtCheck->execute([$idEvent, $idEquipe]);
        $alreadyRegistered = $stmtCheck->fetchColumn();

        if ($alreadyRegistered == 0) {
            // 3. Inscrire l'équipe
            $stmtInsert = $pdo->prepare("INSERT INTO inscriptionequipe (id_evenement, id_equipe) VALUES (?, ?)");
            $stmtInsert->execute([$idEvent, $idEquipe]);
        }       
        

    // Redirection vers les événements
   header('Location: ../pages/evenement.php?success=1');
    exit;
}
