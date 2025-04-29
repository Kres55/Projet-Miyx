<?php

include "pdo.php";
session_start();

$id = $_SESSION["user_id"];

$stmt = $pdo->prepare("INSERT INTO playlist (playlist_name) VALUES (:name) WHERE user_id = '$id'");
$name = $_POST['name'] ?? null;
if (empty($name)) {
    echo json_encode(['success' => false, 'message' => 'Nom de la playlist manquant']);
    exit;
}
if ($stmt->execute(['name' => $name])) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Erreur BDD']);
}
