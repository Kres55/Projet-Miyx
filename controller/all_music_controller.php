<?php

include "pdo.php";
session_start();

header('Content-Type: application/json');



    $sql = "SELECT * FROM music";

    $stmt = $pdo->query($sql);

    $verif = $stmt->execute();

    $musics = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($musics) {
        echo json_encode($musics);
        exit;
    } else {
        echo json_encode(["error" => "pas de musique"]);
        exit;
    }
