<?php

include "pdo.php";
session_start();

header('Content-Type: application/json');


if ($_GET["id"]) {
    $id = $_GET["id"];

    $sql = "SELECT music_id FROM music WHERE music_id < ? ORDER BY music_id DESC LIMIT 1;";

    $stmt = $pdo->prepare($sql);

    $verif = $stmt->execute([$id]);

    $musics = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($musics) {
        echo json_encode($musics);
        exit;
    } else {

        $sql = "SELECT music_id FROM music ORDER BY music_id DESC LIMIT 1";

        $stmt = $pdo->query($sql);

        $musics = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($musics);
        exit;
    }
} else {
    echo json_encode(["error" => "pas d\'id"]);
    exit;
}
