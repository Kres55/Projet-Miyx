<?php

include "pdo.php";
if (!empty($_POST["search"]) && strlen($_POST["search"]) >= 3) {

    $search = $_POST["search"];
    $sql = "SELECT users.user_artistname, music.music_track, music.music_id 
FROM users
LEFT JOIN music ON users.user_id = music.user_id
WHERE user_isartist = 1
   AND (users.user_artistname LIKE :search OR music.music_track LIKE :search)
LIMIT 5;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'search' => "%$search%"
    ]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //var_dump($results);
    //on envoie les données a l'AJAX (TRANSFORME EN JSON(langage universelle) pour communiquer avec le JS)
    echo json_encode($results);
} else {
    echo json_encode(["compteur" => $_POST["search"]]);
}
