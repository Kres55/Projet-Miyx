<?php
include "base.php";
include "../controller/pdo.php";
include "message.php";


if (isset($_GET['page'])) {
    $page = (int) $_GET['page'];
    setcookie('page', $page, time() + (86400 * 30), "/"); // Cookie valable 30 jours
} elseif (isset($_COOKIE['page'])) {
    $page = (int) $_COOKIE['page'];
} else {
    $page = 1; // Valeur par défaut
}

// Pour faire la pagination il nous faut le nombre de musique en tout dans la base de données

$sql_music_count = "SELECT COUNT(*) as total_music FROM music";
$stmt_music_count = $pdo->query($sql_music_count);
$music_count = $stmt_music_count->fetch(PDO::FETCH_ASSOC);
$total = $music_count['total_music'];
$limitPerPage = 3;
$pageTotal = ceil($total / $limitPerPage);


$offset = ($page * $limitPerPage) - $limitPerPage;


$sql = "SELECT * FROM music 
        left join music_genre on music.music_id = music_genre.music_id 
        left join genre on music_genre.genre_id = genre.genre_id 
        LIMIT $offset, $limitPerPage";

// Exécution de la requête
$stmt = $pdo->prepare($sql);
$stmt->execute();
// Vérification de l'exécution de la requête
if ($stmt === false) {
    echo "Erreur lors de l'exécution de la requête.";
} else {
    $musicInfos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $sql_genres = "SELECT DISTINCT genre.genre_id, genre.genre_name FROM genre 
    ORDER BY genre.genre_name ASC";
    $stmt_genres = $pdo->query($sql_genres);
    $allGenres = $stmt_genres->fetchAll(PDO::FETCH_ASSOC);
}



?>

<div class="mt-5 mb-2">
    <div class="d-flex flex-column align-items-center position-relative">
        <input class="form-control mt-2 text-center recherche w-50"
            id="search"
            type="search"
            placeholder="Titre, artiste.."
            aria-label="Search">
        <ul class="list-group mt-2 text-center w-50 opacity-75 mt-5"
            style="z-index: 1; max-height: 200px; overflow-y: auto; position: absolute;"
            id="results">
        </ul>
    </div>
</div>

<main class="d-flex col-md-12">

    <section class="mt-5 text-center h-75 w-50 border-end border-bottom border-3 rounded-2 shadow-lg p-3">
        <h2>Playlist</h2>
        <div>
            <ul class="list-group mb-2" id="playlistList">
                <!-- Les playlists seront affichées ici -->
            </ul>

            <!-- Bouton + pour ajouter une nouvelle playlist -->
            <button id="addPlaylistBtn" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-plus"></i>
            </button>
            <form action="controller/add_playlist_controller.php" method="POST">
                <!-- Champ input caché au début -->
                <div id="playlistInputContainer" class="mt-2" style="display: none;">
                    <input type="text" name="name" id="newPlaylistName" class="form-control" placeholder="Nom de la playlist">
                    <button class="btn btn-sm btn-success mt-1" id="savePlaylistBtn">Créer</button>
                </div>

        </div>
        </form>

    </section>
    <div class="container bg-body-tiertiary rounded-2 shadow-lg p-3">

        <div class="h-100">

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="titre-tab" data-bs-toggle="tab" data-bs-target="#titre" type="button" role="tab" aria-controls="titre" aria-selected="true">Titre</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="genre-tab" data-bs-toggle="tab" data-bs-target="#genre" type="button" role="tab" aria-controls="genre" aria-selected="false">Genre</button>
                </li>
            </ul>


            <div class="tab-content mt-3" id="myTabContent">
                <div class="tab-pane fade show active" id="titre" role="tabpanel" aria-labelledby="titre-tab">
                    <?php

                    foreach ($musicInfos as $musicInfo) {

                    ?>
                        <ul class="list-unstyled d-flex flex-column flex-wrap gap-2">
                            <li>
                                <a href="view/homepage.php?page=<?= $page ?>&id=<?= $musicInfo['music_id'] ?>" class="text-decoration-none text-primary"><?= $musicInfo['music_track'] ?></a>
                            </li>
                        </ul>
                    <?php } ?>

                    <ul class=" pagination justify-content-center">


                        <li class='page-item'>
                            <a class='page-link' href='view/homepage.php?page=<?= $pageTotal ?>'>
                                << </a>
                        </li>

                        <?php

                        for ($i = 1; $i <= $pageTotal; $i++) {
                            if ($i <= $page + 2 && $i >= $page - 2) {
                                echo "<li class='page-item'>
                   <a class='page-link' href='view/homepage.php?page=$i'>$i</a></li>";
                            }
                        }
                        ?>


                        <li class='page-item'>
                            <a class='page-link' href='view/homepage.php?page=<?= $pageTotal ?>'>>></a>
                        </li>





                </div>
                <div class="tab-pane fade" id="genre" role="tabpanel" aria-labelledby="genre-tab">
                    <!-- Sous-onglets des genres -->
                    <ul class="nav nav-tabs mt-3" id="innerTab" role="tablist">
                        <?php foreach ($allGenres as $index => $genre): ?>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link <?= $index === 0 ? 'active' : '' ?>"
                                    id="sub-genre-tab-<?= $genre['genre_id'] ?>"
                                    data-bs-toggle="tab"
                                    data-bs-target="#sub-genre-<?= $genre['genre_id'] ?>"
                                    type="button"
                                    role="tab"
                                    aria-controls="sub-genre-<?= $genre['genre_id'] ?>"
                                    aria-selected="<?= $index === 0 ? 'true' : 'false' ?>">
                                    <?= htmlentities($genre['genre_name']) ?>
                                </button>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                    <!-- Contenu des sous-onglets -->
                    <div class="tab-content mt-2" id="innerTabContent">
                        <?php foreach ($allGenres as $index => $genre): ?>
                            <?php
                            $sql_music_by_genre = "SELECT music.music_id, music.music_track
                                       FROM music
                                       JOIN music_genre ON music.music_id = music_genre.music_id
                                       WHERE music_genre.genre_id = ?";
                            $stmt = $pdo->prepare($sql_music_by_genre);
                            $stmt->execute([$genre['genre_id']]);
                            $musics = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                            <div class="tab-pane fade <?= $index === 0 ? 'show active' : '' ?>"
                                id="sub-genre-<?= $genre['genre_id'] ?>"
                                role="tabpanel"
                                aria-labelledby="sub-genre-tab-<?= $genre['genre_id'] ?>">

                                <?php if (count($musics) > 0): ?>
                                    <ul class="list-unstyled">
                                        <?php foreach ($musics as $music): ?>
                                            <li>
                                                <a href="view/homepage.php?id=<?= $music['music_id'] ?>" class="text-decoration-none text-primary">
                                                    <?= htmlentities($music['music_track']) ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else: ?>
                                    <p class="text-muted">Aucune musique trouvée pour ce genre.</p>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

            </div>


        </div>

    </div>
</main>

<div class="container h-100">
    <div class="row justify-content-center gap-5 mb-4 align-items-stretch h-50">



        <div class="col-md-12">
            <form id="infoMusic" class="w-100 mx-auto border border-3  rounded-2 shadow-lg p-3 mt-5" method="GET">


                <label class="form-label" for="music_track">titre :</label>
                <input class="form-control" type="text" name="music_track" id=music_track readonly>

                <label class="form-label mt-4" for="music_source">Source :</label>
                <input class="form-control" type="text" name="music_source" id="music_source" readonly>

                <label class="form-label mt-4" for="music_license">License :</label>
                <input class="form-control" type="text" name="music_license" id="music_license" readonly>

            </form>
        </div>
        <div class="col-md-12 ">
            <div class="card bg-dark text-white p-3 lecteur">
                <audio id="audio" class=""></audio>

                <input type="range" id="progress" class="form-range w-100 mb-2 me-5" min="0" max="100" step="0.1" value="0">
                <div class="d-flex justify-content-between">
                    <span id="currentTime"></span>
                    <span id="duration"></span>
                </div>


                <div class="mx-auto mb-3 w-100">
                    <button id="mute" class="btn btn-light"><i class="bi bi-volume-up-fill"></i></button>
                    <input type="range" id="volume" class="form-range mx-2 w-25" min="0" max="1" step="0.1" value="0.2">
                    <button id="prev" class="btn btn-light mx-2 ms-1"><i class="bi bi-skip-backward-fill"></i></button>
                    <button id="playPause" class="btn btn-primary mx-1"><i class="bi bi-play-fill"></i></button>
                    <button id="next" class="btn btn-light mx-1"><i class="bi bi-skip-forward-fill"></i></button>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <footer class="">
                <ul class="nav justify-content-center border-bottom pb-3 mb-3">
                    <li class="nav-item"><a href="view/politique_confidentialite.php" class="nav-link px-2 text-body-secondary">Politique de confidentialité</a></li>
                    <li class="nav-item"><a href="view/condition_utilisation.php" class="nav-link px-2 text-body-secondary">Conditions générales d'utilisation</a></li>
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

            // Vérification de l'existence de la musique
            audio.src = "musiques/uploads/" + track.music_path;
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

    document.addEventListener("DOMContentLoaded", () => {
        fetch("controller/view_playlist_controller.php")
            .then(response => response.json())
            .then(data => {
                const list = document.getElementById("playlistList");
                list.innerHTML = ""; // Vide la liste

                if (data.success && data.playlists.length > 0) {
                    data.playlists.forEach(playlist => {
                        const li = document.createElement("li");
                        li.className = "list-group-item";
                        li.style.cursor = "pointer";
                        li.style.backgroundColor = "orange";
                        li.style.color = "blue";
                        li.style.fontWeight = "bold";
                        li.textContent = playlist.playlist_name;
                        list.appendChild(li);
                    });
                } else {
                    list.innerHTML = "<li class='list-group-item'>Aucune playlist</li>";
                }
            })
            .catch(error => {
                console.error("Erreur de récupération des playlists :", error);
            });
    });
</script>