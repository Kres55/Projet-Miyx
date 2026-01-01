<?php
session_start();
include "pdo.php";
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


    if (isset($_FILES['music_path'])) {
        $filename = $_FILES['music_path']["name"]; 
        $filesize = $_FILES['music_path']["size"]; 
        // c'est le nom temporaire, ce qui correspond au fichier, cela permet de le manipuler pendant qu'il est chargé.
        $tmpName = $_FILES['music_path']["tmp_name"];

        $validExtensions = ['mp3', 'wav', 'flac', 'aiff'];

        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if (!in_array($extension, $validExtensions)) {
            header("Location: ../view/upload_music.php?message=Extension non autorisée.&status=error");
            exit;
        }

        // TABLEAU DES MIME AUTORISÉS
        $validMimes = [
            'audio/mpeg',
            'audio/wav',
            'audio/x-wav',
            'audio/flac',
            'audio/aiff',
            'audio/x-aiff'
        ];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime  = finfo_file($finfo, $tmpName);
        finfo_close($finfo);

        if (!in_array($mime, $validMimes)) {
            header("Location: ../view/upload_music.php?message=Type de fichier invalide.&status=error");
            exit;
        }


        // On verifie que l'extension est bien dans le tableau
        if (in_array($extension, $validExtensions)) {
            if ($filesize < 73400320) {
                // renomme pour eviter les doublons et concaténer avec l'extension.
                $newName = sha1(uniqid(mt_rand(), true)) . "." . $extension;

                try {
                    // On déplace le fichier temporaire vers le dossier de destination.
                    //var_dump("../musiques/uploads/" . $newName);
                    if (move_uploaded_file($tmpName, "../musiques/uploads/" . $newName)) {
                        //echo "Le fichier a été uploadé avec succès.";


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
                        //echo "Le fichier n'a pas pu être uploadé.";
                        exit;
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
