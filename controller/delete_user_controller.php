<?php
session_start();
include "pdo.php";

if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['token']) {
    // Token absent ou invalide : on bloque
    header("Location: ../view/profile_user.php?message=Erreur CSRF détectée!&status=error");
    exit;
}

if (isset($_POST['user_id'])) {
    $id = $_POST['user_id'];
    $sql = "DELETE FROM users WHERE user_id=?";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$id])) {
        header("Location: ../view/homepage.php?message=Exécution réussie&status=success");
    } else {
        header("Location: ../view/homepage.php?message=Probleme de base de donnée, appellez un developpeur&status=error");
    }
}else{
    header("Location: ../view/homepage.php?message=Erreur de suppression&status=error");
}