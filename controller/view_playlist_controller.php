<?php
include "pdo.php";
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
$userId = $_SESSION["user_id"] ?? null;

// Vérifie que l'utilisateur EST connecté
if ($userId === null) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non connecté']);
    exit;
}

$stmt = $pdo->prepare("SELECT playlist_id, playlist_name FROM playlist WHERE user_id = :user_id");
$stmt->execute(['user_id' => $userId]);
$playlists = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['success' => true, 'playlists' => $playlists]);
