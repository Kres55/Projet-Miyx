<?php
session_start();
include "pdo.php";

if (
    !empty($_POST['user_firstname']) &&
    !empty($_POST['user_lastname']) &&
    !empty($_POST['user_mail']) &&
    !empty($_POST['user_password']) &&
    isset($_POST['artist'])
) {

    // Exemple d'algo de hashage
    // md5, sha1, sha2, sha256, sha512
    // Argon2 => Argon2I et l'Argon2d


    $psw = password_hash($_POST["user_password"], PASSWORD_ARGON2I);

    $is_artist = $_POST['artist'] === 'yes' ? 1 : 0;

    $sql = "INSERT INTO users (user_firstname, user_lastname, user_mail, user_password, user_isartist) VALUES (?,?,?,?,?)";

    $stmt = $pdo->prepare($sql);
    $verif = $stmt->execute([
        $_POST["user_firstname"],
        $_POST["user_lastname"],
        $_POST["user_mail"],
        $psw,
        $is_artist
    ]);
    if ($verif) {
        $_SESSION['user_isartist'] = $is_artist;
        header("Location: ../view/homepage.php?message=Inscription réussie&status=success");
    } else {
        header("Location: ../view/sign_up.php?message=Erreur serveur, appelez le developpeur.&status=error");
    }
} else {
// Ici le formulaire est mal rempli
header("Location: ../view/sign_up.php?message=Veuillez remplir le formulaire correctement&status=error");
}
