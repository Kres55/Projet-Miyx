<?php
include "base.php";
include "../controller/pdo.php";
include "message.php";
?>

<div class="container">
    <h1 class="text-center text-primary">Uploadez votre musique</h1>

    <form action="controller/upload_music_controller.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="music_track" class="form-label">Titre de la musique</label>
            <input type="text" class="form-control" id="music_track" name="music_track" required>
        </div>
        <div class="mb-3">
            <label for="genre_name" class="form-label">Genre</label>
            <select class="form-select" id="genre_name" name="genre_name">
                <?php
                $sql = "SELECT * FROM genre";
                $stmt = $pdo->query($sql);
                $genres = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($genres as $genre) {
                    echo "<option value='{$genre['genre_id']}'>{$genre['genre_name']}</option>";
                }
                ?>
            </select>

        </div>


        <label for="music_path" class="form-label">Fichier de musique</label>
        <input type="file" class="form-control" id="music_path" name="music_path" accept=".mp3, .wav, .flac, .aiff" required>



        <p class="bold-3 text-warning mt-4"> Afin de vous crediter comme il se doit indiquez ou l'on peut trouver votre musique , ainsi que le lien de votre license</p>

        <div class="mb-3">
            <label for="music_source" class="form-label">Source</label>
            <input type="text" class="form-control" id="music_source" name="music_source" placeholder="lien vers votre musique..." required>
        </div>
        <div class="mb-3">
            <label for="music_licence" class="form-label">License</label>
            <input type="text" class="form-control" id="music_licence" name="music_licence" placeholder="lien vers la license lié a votre musique..." required>
        </div>
</div>
<div class="text-center">
    <input type="submit" value="Uploader la musique" class="btn btn-primary my-3">
</div>
</form>
</div>






</body>

</html>