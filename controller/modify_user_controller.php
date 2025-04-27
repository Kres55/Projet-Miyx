<?php

include "pdo.php";
session_start();

if (!isset($_SESSION['name'])) {
    header('Location: ../view/login.php');
    exit;
}

if (
    !empty($_POST["user_firstname"]) &&
    !empty($_POST["user_lastname"]) &&
    !empty($_POST["user_mail"])
) {

    $sql = "UPDATE users SET user_firstname = ?, user_lastname = ?, user_mail = ? WHERE user_id =? ";

    $stmt = $pdo->prepare($sql);
    $verif = $stmt->execute([
        $_POST["user_firstname"],
        $_POST["user_lastname"],
        $_POST["user_mail"],
        $_SESSION['user_id']
    ]);

    if ($verif) {
        $_SESSION['name'] = $_POST["user_firstname"];
        header("Location: ../view/modify_user.php?message=Mise à jour reussi&status=success");
        exit;
    } else {
        header("Location: ../view/modify_user.php?message=Problème serveur&status=error");
        exit;
    }
} else {
    // Message d'erreur formulaire incomplet
    header("Location: ../view/modify_user.php?message=Formulaire incomplet&status=error");
    exit;
}
