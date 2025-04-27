<?php
include "base.php";
include "../controller/pdo.php";
include "message.php";
?>

<div class="container">
    <h1 class="text-center text-primary">Uploadez votre musique</h1>

    <form action="/controller/upload_music_controller.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="music_track" class="form-label">Titre de la musique</label>
            <input type="text" class="form-control" id="music_track" name="music_track" required>
        </div>
        <div class="mb-3">
            <label for="music_genre_id" class="form-label">Genre</label>
            <select class="form-select" id="music_genre_id" name="music_genre_id">
                <?php
                $sql = "SELECT * FROM genre";
                $stmt = $pdo->query($sql);
                $genres = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($genres as $genre) {
                    echo "<option value='{$genre['genre_id']}'>{$genre['genre_music']}</option>";
                }
                ?>
            </select>

            <label for="artist_name" class="form-label">Auteur</label>
            <input type="text" class="form-control" id="artist_name" name="artist_name" required>
        </div>


            <label for="music_file" class="form-label">Fichier de musique</label>
            <input type="file" class="form-control" id="music_file" name="music_file" accept=".mp3, .wav, .ogg, .mp4" required>
        </div>
        <div class="text-center">
            <input type="submit" value="Uploader la musique" class="btn btn-primary my-3">
        </div>
    </form>
</div>






</body>

</html>