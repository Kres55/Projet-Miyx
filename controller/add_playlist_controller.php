<?php
include "pdo.php";
session_start();

$id = $_SESSION["user_id"] ?? null;
$name = $_POST['name'] ?? null;

// Validation
if (empty($id) || empty($name)) {
    header("Location: ../view/login.php?message=Veuillez vous reconnecter&status=error");
    exit;
}

// Préparer et exécuter la requête
$stmt = $pdo->prepare("INSERT INTO playlist (playlist_name, user_id) VALUES (:name, :user_id)");
if ($stmt->execute(['name' => $name, 'user_id' => $id])) {
    header("Location: ../view/homepage.php?message=Playlist crée avec succès&status=success&page=1");
} else {
    header("Location: ../view/homepage.php?message=Erreur base de donnée&status=error&page=1");
}
