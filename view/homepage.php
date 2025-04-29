<?php

include "base.php";
include "../controller/pdo.php";
include "message.php";

$sql = "SELECT * FROM music left join music_genre on music.music_id = music_genre.music_id left join genre on music_genre.genre_id = genre.genre_id";
$stmt = $pdo->prepare($sql);
$stmt->execute();
// Vérification de l'exécution de la requête
if ($stmt === false) {
    echo "Erreur lors de l'exécution de la requête.";
} else {
    $musicInfos = $stmt->fetchAll(PDO::FETCH_ASSOC);
}



?>
<main class="d-flex">
    <section class="mt-5 text-center h-50">
        <h2>Playlist</h2>
        <div>
            <ul class="list-group mb-2" id="playlistList">
                <!-- Les playlists seront affichées ici -->
            </ul>

            <!-- Bouton + pour ajouter une nouvelle playlist -->
            <button id="addPlaylistBtn" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-plus"></i> <!-- Icône Bootstrap -->
            </button>

            <!-- Champ input caché au début -->
            <div id="playlistInputContainer" class="mt-2" style="display: none;">
                <input type="text" id="newPlaylistName" class="form-control" placeholder="Nom de la playlist">
                <button class="btn btn-sm btn-success mt-1" id="savePlaylistBtn">Créer</button>
            </div>

        </div>

    </section>
    <div class="container">
        <div class="d-flex justify-content-center mt-5 mb-2">
            <input class="form-control me-2 mt-2 text-center recherche w-50"
                id="search"
                type="search"
                placeholder="Titre, artiste.."
                aria-label="Search">
            <ul class="list-group d-flex flex-column mt-2 text-center w-100 opacity-75 "
                id="results">
            </ul>
        </div>

        <div class="h-100">

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="titre-tab" data-bs-toggle="tab" data-bs-target="#titre" type="button" role="tab" aria-controls="titre" aria-selected="true">Titre</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="genre-tab" data-bs-toggle="tab" data-bs-target="#genre" type="button" role="tab" aria-controls="genre" aria-selected="false">Genre</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="artiste-tab" data-bs-toggle="tab" data-bs-target="#artiste" type="button" role="tab" aria-controls="artiste" aria-selected="false">Artiste</button>
                </li>
            </ul>


            <div class="tab-content mt-3" id="myTabContent">
                <div class="tab-pane fade show active" id="titre" role="tabpanel" aria-labelledby="titre-tab">
                    <?php

                    foreach ($musicInfos as $musicInfo) {

                    ?>
                        <ul class="list-unstyled">
                            <li>
                                <a href="view/homepage.php?id=<?= $musicInfo['music_id'] ?>" class="text-decoration-none text-primary"><?= $musicInfo['music_track'] ?></a>
                            </li>
                        </ul>
                    <?php } ?>
                </div>
                <div class="tab-pane fade" id="genre" role="tabpanel" aria-labelledby="genre-tab">
                    <!-- Onglets internes -->
                    <ul class="nav nav-tabs mt-3" id="innerTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="sub-genre-tab" data-bs-toggle="tab" data-bs-target="#sub-genre" type="button" role="tab" aria-controls="sub-genre" aria-selected="true">
                                <?= $musicInfo['genre_name'] ?>
                            </button>
                        </li>
                    </ul>

                    <!-- Contenu des sous-onglets -->
                    <div class="tab-content mt-2" id="innerTabContent">
                        <div class="tab-pane fade show active" id="sub-genre" role="tabpanel" aria-labelledby="sub-genre-tab">
                            <ul class="list-unstyled">
                                <li>
                                    <a href="view/homepage.php?id=<?= $musicInfo['music_id'] ?? '' ?>" class="text-decoration-none text-primary">
                                        <?= $musicInfo['genre_music'] ?? '' ?>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="artiste" role="tabpanel" aria-labelledby="artiste-tab">
                    <p>Contenu de l'onglet Artiste.</p>
                </div>
            </div>


        </div>

    </div>
</main>

<div class="container h-100">
    <div class="row justify-content-center gap-5 border-top mb-4 align-items-stretch  h-100">



        <div class="col-md-12">
            <form id="infoMusic" class="w-100 mx-auto border border-3 border-primary rounded-2 shadow-lg p-3 mb-2 mt-5" method="GET">


                <label class="form-label" for="music_track">titre :</label>
                <input class="form-control" type="text" name="music_track" id=music_track readonly>

                <label class="form-label mt-4" for="music_source">Source :</label>
                <input class="form-control" type="text" name="music_source" id="music_source" readonly>

                <label class="form-label mt-4" for="music_license">License :</label>
                <input class="form-control" type="text" name="music_license" id="music_license" readonly>

            </form>
        </div>
        <div class="col-md-12">
            <div class="card bg-dark text-white p-3 lecteur">
                <audio id="audio" class=""></audio>

                <input type="range" id="progress" class="form-range w-100 mb-2 me-5" min="0" max="100" step="0.1" value="0">
                <div class="d-flex justify-content-between">
                    <span id="currentTime"></span>
                    <span id="duration"></span>
                </div>


                <div class="mx-auto mb-3 w-100">
                    <button id="mute" class="btn btn-light"><i class="bi bi-volume-up-fill"></i></button>
                    <input type="range" id="volume" class="form-range mx-3  w-25" min="0" max="1" step="0.1" value="0.2">
                    <button id="prev" class="btn btn-light mx-2 ms-5"><i class="bi bi-skip-backward-fill"></i></button>
                    <button id="playPause" class="btn btn-primary mx-2"><i class="bi bi-play-fill"></i></button>
                    <button id="next" class="btn btn-light mx-2"><i class="bi bi-skip-forward-fill"></i></button>


                </div>
            </div>
        </div>
        <div class="col-md-12">
            <footer class="">
                <ul class="nav justify-content-center border-bottom pb-3 mb-3">
                    <li class="nav-item"><a href="legal_notices.php" class="nav-link px-2 text-body-secondary">Mentions légales</a></li>
                </ul>
                <p class="text-center text-body-secondary">&copy; 2025 Miyx</p>
            </footer>
        </div>
    </div>


</div>

</body>


</html>

<script>
    const audio = document.getElementById("audio");
    const playPauseBtn = document.getElementById("playPause");
    const muteBtn = document.getElementById("mute");
    const volumeSlider = document.getElementById("volume");
    const progressBar = document.getElementById("progress");
    const currentTimeDisplay = document.getElementById("currentTime");
    const durationDisplay = document.getElementById("duration");

    const titleInput = document.getElementById("music_track");
    const licenseInput = document.getElementById("music_license");
    const sourceInput = document.getElementById("music_source");

    let isPlaying = false;

    let parsedUrl = new URL(window.location.href);
    // console.log(parsedUrl.searchParams.get("id"));
    let id = parsedUrl.searchParams.get("id");


    // Affiche le champ
    document.getElementById('addPlaylistBtn').addEventListener('click', function() {
        document.getElementById('playlistInputContainer').style.display = 'block';
        document.getElementById('newPlaylistName').focus();
    });

    // Crée la playlist quand on clique sur "Créer"
    document.getElementById('savePlaylistBtn').addEventListener('click', function() {
        const name = document.getElementById('newPlaylistName').value.trim();

        if (name === '') return;

        fetch('controller/add_playlist_controller.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'name=' + encodeURIComponent(name)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Ajoute la playlist dans la liste
                    const li = document.createElement('li');
                    li.className = 'list-group-item';
                    li.textContent = name;
                    document.getElementById('playlistList').appendChild(li);

                    // Réinitialise
                    document.getElementById('newPlaylistName').value = '';
                    document.getElementById('playlistInputContainer').style.display = 'none';
                } else {
                    alert('Erreur: ' + data.message);
                }
            })
            .catch(err => console.error('Erreur AJAX:', err));
    });

    fetch("controller/view_music_controller.php?id=" + id)
        .then(res => res.json())
        .then(track => {
            //console.log(track);

            audio.src = track.music_path;
            titleInput.value = typeof(track.music_track) !== "undefined" ? track.music_track : "";
            licenseInput.value = typeof(track.music_licence) !== "undefined" ? track.music_licence : "";
            sourceInput.value = typeof(track.music_source) !== "undefined" ? track.music_source : "";
        });


    playPauseBtn.addEventListener("click", () => {
        if (isPlaying) {
            audio.pause();
        } else {
            audio.play();
        }
    });

    audio.addEventListener("play", () => {
        isPlaying = true;
        playPauseBtn.innerHTML = `<i class="bi bi-pause-fill"></i>`;
    });

    audio.addEventListener("pause", () => {
        isPlaying = false;
        playPauseBtn.innerHTML = `<i class="bi bi-play-fill"></i>`;
    });

    audio.addEventListener("timeupdate", () => {
        progressBar.value = (audio.currentTime / audio.duration) * 100 || 0;
        currentTimeDisplay.textContent = formatTime(audio.currentTime);
        durationDisplay.textContent = formatTime(audio.duration);
    });

    progressBar.addEventListener("input", () => {
        audio.currentTime = (progressBar.value / 100) * audio.duration;
    });

    volumeSlider.addEventListener("input", () => {
        audio.volume = volumeSlider.value;
    });

    muteBtn.addEventListener("click", () => {
        audio.muted = !audio.muted;
        muteBtn.innerHTML = audio.muted ? `<i class="bi bi-volume-mute-fill"></i>` : `<i class="bi bi-volume-up-fill"></i>`;
    });

    function formatTime(seconds) {
        const mins = Math.floor(seconds / 60);
        const secs = Math.floor(seconds % 60).toString().padStart(2, "0");
        return `${mins}:${secs}`;
    }

    // console.log(audio.duration);
    search.addEventListener("input", function() {
        let v = this.value;
        fetch(
                `controller/search.php?search=${v}`
            )
            .then((response) => response.json())
            .then((musics) => {
                let res = musics.results;
                results.innerHTML = "";
                res.forEach((el) => {
                    let li = document.createElement("li");
                    li.classList.add("list-group-item", "search-list");
                    li.innerHTML = el.title;
                    li.addEventListener("click", function() {
                        console.log(el.id);
                        window.location.href = `view/homepage.php?music_id=${el.id}`;
                    });
                    results.appendChild(li);
                });
            })
            .catch((err) => console.error(err));
    });
</script>