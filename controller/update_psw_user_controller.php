<?php

include 'pdo.php';
session_start();

if (!isset($_SESSION['name'])) {
    header('Location: ../view/login.php');
    exit;
}

if (!empty($_POST['old_psw_user']) && !empty($_POST['user_password'])) {

    $id = $_SESSION["user_id"];
    // on va récupérer le hashage de l'ancien mot de passe.

    $sql_old = "SELECT user_password FROM users WHERE user_id = '$id'";
    $stmt_old = $pdo->query($sql_old);
    $psw_old = $stmt_old->fetch(PDO::FETCH_ASSOC);

    // On verifie le vieux mot de passe
    if (password_verify($_POST['old_psw_user'], $psw_old['user_password'])) {
        // L'ancien mot de passe est valide
        $new_psw = password_hash($_POST['user_password'], PASSWORD_ARGON2I);

        $sql = "UPDATE users SET user_password = ? WHERE user_id = ?";
        $stmt = $pdo->prepare($sql);
        $verif = $stmt->execute([
            $new_psw,
            $id
        ]);

        if ($verif) {
            header("Location: ../view/psw_update_form.php?message=mise à jour du mot de passe réussi.&status=success");
            exit;
        } else {
            header("Location: ../view/psw_update_form.php?message=Erreur SQL&status=error");
            exit;
        }
    } else {
        header("Location: ../view/psw_update_form.php?message=L'ancien mot de passe n'est pas valide&status=error");
        exit;
    }
} else {
    header("Location: ../view/psw_update_form/message=Formulaire invalide&status=error");
    exit;
}
