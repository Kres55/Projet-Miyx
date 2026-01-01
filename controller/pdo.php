<?php

require_once '../vendor/autoload.php';

use Dotenv\Dotenv;

// Dotenv à besoin de savoir ou est le fichier .env
// Dans ce cas ci, à la racine du projet
$dotenv = Dotenv::createImmutable("../");
// Maintenant que dotenv sais où est le fichier, il le charge
$dotenv->load();


$host = $_ENV['DB_HOST'];
$name = $_ENV['DB_NAME'];
$user = $_ENV['DB_USER'];
$psw = $_ENV['DB_PSW'];


try {
    $pdo = new PDO("mysql:host=$host;dbname=$name", $user, $psw);
    $pdo->exec('SET NAMES utf8');
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : ." . $e->getMessage());
}