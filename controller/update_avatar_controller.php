<?php
session_start();
include "pdo.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../view/login.php");
    exit;
}

if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {
    $tmpName = $_FILES['avatar']['tmp_name'];
    $filename = $_FILES['avatar']['name'];
    $filesize = $_FILES['avatar']['size'];
    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    $validExtensions = ['jpg', 'jpeg', 'png'];
    if ($_SESSION['user_isartist']) {
        $validExtensions[] = 'gif'; // premium = autorise gif
    }

    if (in_array($extension, $validExtensions)) {
        if ($filesize <= 5 * 1024 * 1024) { // 5Mo max
            $newName = sha1(uniqid()) . "." . $extension;
            if (move_uploaded_file($tmpName, "../avatars/" . $newName)) {
                $sql = "UPDATE users SET user_avatar = ? WHERE user_id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$newName, $_SESSION['user_id']]);

                header("Location: ../view/profile_user.php?message=Avatar mis à jour&status=success");
                exit;
            }
        } else {
            $msg = "Fichier trop volumineux (5Mo max)";
        }
    } else {
        $msg = "Extension non autorisée.";
    }
} else {
    $msg = "Erreur lors de l’envoi du fichier.";
}

// header("Location: ../view/profile_user.php?message=" . urlencode($msg) . "&status=error");
// exit;
