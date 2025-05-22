<?php
// Paramètres de connexion
$host = 'mysql-esportify2025.alwaysdata.net';
$dbname = 'esportify2025_db';
$user = '414530';
$pass = 'SeoulKyoto';

// Options PDO sécurisées
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass, $options);
} catch (PDOException $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}
?>
