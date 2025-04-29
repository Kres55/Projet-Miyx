<?php

include "pdo.php";
session_start();

header('Content-Type: application/json');


if($_GET["id"]){

    $sql = "SELECT * FROM music WHERE music_id = ?";

    $stmt = $pdo->prepare($sql);
    
   $verif = $stmt->execute([$_GET["id"]]);

    $musics = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($musics) {
        echo json_encode($musics);
        exit;
    } else {
        echo json_encode(["error" => "pas de musique"]);
        exit;
    }
}else{
    echo json_encode(["error" => "pas d\'id"]);
    exit;
}