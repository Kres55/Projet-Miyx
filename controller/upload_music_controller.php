<?php

include "pdo.php";
session_start();

if (
    !empty($_POST['music_track']) &&
    !empty($_POST['music_genre']) &&
    !empty($_POST['artist_name'])
) {
    $sql = "INSERT INTO music (music_track, music_genre_id) VALUES (?,?)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_POST["music_track"],
        $_POST["music_genre_id"]
    ]);

    $sql = "INSERT INTO artist (artist_name) 
    VALUES (?)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_POST["artist_name"],
    ]);
}


if (isset($_FILES['music_path'])) {
    $filename = $_FILES['music_path']["name"];
    $filesize = $_FILES['music_path']["size"];
    $tmpName = $_FILES['music_path']["tmp_name"];

    $explodeName = explode(".", $filename);
    $extension = strtolower(end($explodeName));
    $validExtensions = ['mp3', "wav", "ogg", "mp4"];

    if (in_array($extension, $validExtensions)) {
        if ($filesize < 2097152) {
            $newName = sha1(uniqid(mt_rand(), true)) . "." . $extension;

            try {
                move_uploaded_file($tmpName, "../musiques/uploads/" . $newName);
                $id = $_SESSION['user_id'];
                $sql = "INSERT INTO music(music_path) VALUES '$newName'";
                $stmt = $pdo->prepare($sql);
                $verif = $stmt->execute();

            } catch (Exception $e) {
                $message = $e->getMessage();
                header("Location: view/upload_music.php?message=$message&status=error");
                exit;
            }
        } else {
            header("Location: view/upload_music.php?message=Fichier trop volumineux.&status=error");
            exit;
        }
    } else {
        header("Location: view/upload_music.php?message=Format d'image invalide.&status=error");
        exit;
    }
} else {
    header("Location: view/upload_music.php?message=Veuillez insérer un fichier image.&status=error");
    exit;
}
