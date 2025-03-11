<?php

include "pdo.php";

if (
    !empty($_POST['user_firstname']) &&
    !empty($_POST['user_lastname']) &&
    !empty($_POST['user_mail']) &&
    !empty($_POST['user_password'])
) {

    // Exemple d'algo de hashage
    // md5, sha1, sha2, sha256, sha512
    // Argon2 => Argon2I et l'Argon2d

    $psw = password_hash($_POST["user_password"], PASSWORD_ARGON2I);

    $sql = "INSERT INTO users (user_firstname, user_lastname, user_mail, user_password) VALUES (?,?,?,?)";

    $stmt = $pdo->prepare($sql);
    $verif = $stmt->execute([
        $_POST["user_firstname"],
        $_POST["user_lastname"],
        $_POST["user_mail"],
        $psw,
    ]);
    if ($verif) {
        header("Location: ../view/homepage.php?message=Inscription réussie&status=success");
    } else {
        header("Location: ../view/sign_up.php?message=Erreur serveur, appelez le developpeur.&status=error");
    }
} else {
// Ici le formulaire est mal remplis
header("Location: ../view/sign_up.php?message=Veuillez remplir le formulaire correctement&status=error");
}
