<?php

include "pdo.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM users WHERE id_user=?";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$id])) {
        header("Location: ../homepage.php?message=Exécution réussie&status=success");
    } else {
        header("Location: ../homepage.php?message=Probleme de base de donnée, appellez un developpeur&status=error");
    }
}