<?php

include "base.php";
include "../controller/pdo.php";
include "message.php";

?>


        <div class="card bg-dark text-white p-3 container lecteur">
            <audio id="audio" class="d-none"></audio>

            <!-- Barre de progression -->
            <input type="range" id="progress" class="form-range w-100 mb-2" value="0">
            <div class="d-flex justify-content-between">
                <span id="currentTime">0:00</span>
                <span id="duration">0:00</span>
            </div>

            <!-- Boutons -->
            <div class="d-flex justify-content-center mb-3">
                <button id="prev" class="btn btn-light mx-2"><i class="bi bi-skip-backward-fill"></i></button>
                <button id="playPause" class="btn btn-primary mx-2"><i class="bi bi-play-fill"></i></button>
                <button id="next" class="btn btn-light mx-2"><i class="bi bi-skip-forward-fill"></i></button>
            </div>

            <!-- Contrôle du volume -->
            <div class="d-flex align-items-center mt-3">
                <button id="mute" class="btn btn-light"><i class="bi bi-volume-up-fill"></i></button>
                <input type="range" id="volume" class="form-range mx-2" min="0" max="1" step="0.1" value="1">
            </div>
        </div>

    <script src="script.js"></script>
</body>

</html>






<div class="container">
    <footer class="py-3 my-4">
        <ul class="nav justify-content-center border-bottom pb-3 mb-3">
            <li class="nav-item"><a href="homepage.php" class="nav-link px-2 text-body-secondary">Accueil</a></li>
            <li class="nav-item"><a href="artists.php" class="nav-link px-2 text-body-secondary">Artistes</a></li>
            <li class="nav-item"><a href="genres.php" class="nav-link px-2 text-body-secondary">Genres</a></li>
            <li class="nav-item"><a href="legal_notices.php" class="nav-link px-2 text-body-secondary">Mentions légales</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary"></a></li>
        </ul>
        <p class="text-center text-body-secondary">&copy; 2025 Miyx</p>
    </footer>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>

<script>
    const audio = new Audio();
    const playlist = ["audio1.mp3", "audio2.mp3", "audio3.mp3"];
    let currentTrack = 0;
    audio.src = playlist[currentTrack];

    const playPauseBtn = document.getElementById("playPause");
    const progressBar = document.getElementById("progress");
    const currentTimeDisplay = document.getElementById("currentTime");
    const durationDisplay = document.getElementById("duration");
    const volumeControl = document.getElementById("volume");
    const muteBtn = document.getElementById("mute");
    const nextBtn = document.getElementById("next");
    const prevBtn = document.getElementById("prev");

    // // Chargement de la durée totale
    // audio.addEventListener("loadedmetadata", () => {
    //     durationDisplay.textContent = formatTime(audio.duration);
    // });

    // // Lecture/Pause
    // playPauseBtn.addEventListener("click", () => {
    //     if (audio.paused) {
    //         audio.play();
    //         playPauseBtn.innerHTML = '<i class="bi bi-pause-fill"></i>';
    //     } else {
    //         audio.pause();
    //         playPauseBtn.innerHTML = '<i class="bi bi-play-fill"></i>';
    //     }
    // });

    // // Mise à jour de la barre de progression
    // audio.addEventListener("timeupdate", () => {
    //     progressBar.value = (audio.currentTime / audio.duration) * 100;
    //     currentTimeDisplay.textContent = formatTime(audio.currentTime);
    // });

    // // Changer la position de lecture
    // progressBar.addEventListener("input", () => {
    //     audio.currentTime = (progressBar.value / 100) * audio.duration;
    // });

    // // Boutons Suivant / Précédent
    // nextBtn.addEventListener("click", () => {
    //     currentTrack = (currentTrack + 1) % playlist.length;
    //     changeTrack();
    // });

    // prevBtn.addEventListener("click", () => {
    //     currentTrack = (currentTrack - 1 + playlist.length) % playlist.length;
    //     changeTrack();
    // });

    // function changeTrack() {
    //     audio.src = playlist[currentTrack];
    //     audio.play();
    //     playPauseBtn.innerHTML = '<i class="bi bi-pause-fill"></i>';
    // }

    // // Contrôle du volume
    // volumeControl.addEventListener("input", () => {
    //     audio.volume = volumeControl.value;
    // });

    // // Bouton Mute
    // muteBtn.addEventListener("click", () => {
    //     if (audio.muted) {
    //         audio.muted = false;
    //         muteBtn.innerHTML = '<i class="bi bi-volume-up-fill"></i>';
    //     } else {
    //         audio.muted = true;
    //         muteBtn.innerHTML = '<i class="bi bi-volume-mute-fill"></i>';
    //     }
    // });

    // // Fonction pour formater le temps (ex: 2:03)
    // function formatTime(seconds) {
    //     let min = Math.floor(seconds / 60);
    //     let sec = Math.floor(seconds % 60);
    //     return `${min}:${sec.toString().padStart(2, "0")}`;
    // }
</script>