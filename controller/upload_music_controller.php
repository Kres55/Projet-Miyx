<?php

include "pdo.php";
session_start();
// echo 'upload_max_filesize = ' . ini_get('upload_max_filesize') . "<br>";
// echo 'post_max_size = ' . ini_get('post_max_size') . "<br>";


if (!isset($_SESSION['user_id'])) {
    header("Location: ../view/login.php?message=Veuillez vous connecter pour uploader une musique.&status=error");
    exit;
}

// recuperer l'upload l'id de la musique que je viens d'uploadé , ! pas de requete , une fonction(last id) c'est avec pdo , recupere l'id de genre et l'inserer dans la table music genre, music genre doit etre fait en dernier


if (
    !empty($_POST['music_track']) &&
    !empty($_POST['genre_name']) &&
    !empty($_POST['music_source']) &&
    !empty($_POST['music_licence'])
) {

    // if (!isset($_FILES['music_path'])) {
    //     echo " Aucun fichier reçu dans $_FILES.<br>";
    // } else {
    //     echo " Fichier trouvé dans $_FILES.<br>";

    //     $tmpName = $_FILES['music_path']['tmp_name'];
    //     $errorCode = $_FILES['music_path']['error'];

    //     // Vérifie l'erreur d'upload
    //     if ($errorCode !== UPLOAD_ERR_OK) {
    //         echo " Erreur d'upload : Code $errorCode<br>";
    //     } else {
    //         echo " Upload sans erreur.<br>";
    //     }

    //     // Vérifie si le fichier temporaire existe
    //     if (!is_uploaded_file($tmpName)) {
    //         echo " Le fichier temporaire n'est pas reconnu comme un fichier uploadé valide.<br>";
    //     } elseif (!file_exists($tmpName)) {
    //         echo " Le fichier temporaire n'existe pas physiquement.<br>";
    //     } else {
    //         echo " Le fichier temporaire est présent et reconnu.<br>";
    //     }

    //     // Bonus : afficher la taille du fichier
    //     echo "Taille du fichier uploadé : " . $_FILES['music_path']['size'] . " octets<br>";
    // }




    // $sqlGenre = "SELECT genre (genre_name) VALUES (?)";

    // $stmt = $pdo->prepare($sqlGenre);
    // $stmt->execute([
    //     $_POST["genre_name"],
    // ]);


    if (isset($_FILES['music_path'])) {
        $filename = $_FILES['music_path']["name"]; // c'est le nom du fichier
        $filesize = $_FILES['music_path']["size"]; // c'est sa taille en octets
        // c'est le nom temporaire, ce qui correspond au fichier, cela permet de le manipuler pendant qu'il est charger.
        $tmpName = $_FILES['music_path']["tmp_name"];

        // exemple spark.mp3 => ["spark", "mp3"]
        $explodeName = explode(".", $filename);
        // Il met tout en minuscule et prends le dernier element du tableau : mp3.
        $extension = strtolower(end($explodeName));

        $validExtensions = ["wav", "flac", "aiff", "mp3"];

        // On verifie que l'extension est bien dans le tableau
        if (in_array($extension, $validExtensions)) {
            // On verifie que le fichier fait moins de 70Mo
            if ($filesize < 73400320) {
                // Il faut renommer pour eviter les doublons et concaténer avec l'extension.
                $newName = sha1(uniqid(mt_rand(), true)) . "." . $extension;

                try {
                    // On déplace le fichier temporaire vers le dossier de destination.
                    //var_dump("../musiques/uploads/" . $newName);
                    if (move_uploaded_file($tmpName, "../musiques/uploads/" . $newName)) {
                        echo "Le fichier a été uploadé avec succès.";


                        $id = $_SESSION['user_id'];
                        $sql = "INSERT INTO music (music_path, music_track, music_source, music_licence, user_id) VALUES (?,?,?,?,?)";
                        $stmt = $pdo->prepare($sql);
                        $verif = $stmt->execute([
                            $newName,
                            $_POST["music_track"],
                            $_POST["music_source"],
                            $_POST["music_licence"],
                            $id
                        ]);
                    } else {
                        echo "Le fichier n'a pas pu être uploadé.";
                    }

                    $idMusic = $pdo->lastInsertId();
                    $sqlGenre = "INSERT INTO music_genre (music_id, genre_id) VALUES (?, ?)";
                    $stmt = $pdo->prepare($sqlGenre);
                    $stmt->execute([
                        $idMusic,
                        $_POST["genre_name"]
                    ]);
                    header("Location: ../view/upload_music.php?message=Upload réussi&status=success");
                    exit;
                    // je t'ai rajoué le message de succces.

                } catch (Exception $e) {
                    $message = $e->getMessage();
                    header("Location: ../view/upload_music.php?message=$message&status=error");
                    exit;
                }
            } else {
                header("Location: ../view/upload_music.php?message=Fichier trop volumineux.&status=error");
                exit;
            }
        } else {
            header("Location: ../view/upload_music.php?message=Format de fichier invalide.&status=error");
            exit;
        }
    } else {
        header("Location: ../view/upload_music.php?message=Veuillez choisir un fichier à uploader.&status=error");
        exit;
    }
} else {
    header("Location: ../view/upload_music.php?message=Veuillez remplir le formulaire d'upload correctement.&status=error");
    exit;
}
