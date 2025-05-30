<?php session_start();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <base href="http://localhost/Projet-Miyx/">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" integrity="sha384-tViUnnbYAV00FLIhhi3v/dWt3Jxw4gZQcNoSCxCIFNJVCx7/D55/wXsrNIRANwdD" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/darkmode-js@1.5.7/lib/darkmode-js.min.js"></script>
  <script defer src="JS/search.js"></script>
  <!-- <script defer src="script.js"></script> -->
  <link rel="stylesheet" href="css/style.css">
  <title>Miyx - Ecoutez de la musique indépendante gratuitement</title>
</head>

<body class="">
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand titre" href="view/homepage.php?page=1">Miyx</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item dropdown">
            <ul class="dropdown-menu">
            </ul>
          </li>
          <?php if (!isset($_SESSION['name'])) { ?>
            <li class="nav-item">
              <a class="nav-link text-primary" href="view/login.php">Connexion</a>
            </li>
          <?php } else { ?>
            <li class="nav-item">
              <a class="nav-link text-primary" href="controller/logout.php">Déconnexion</a>
            </li>
          <?php } ?>

          <li class="nav-item">
            <?php if (!isset($_SESSION['name'])) { ?>
              <a class="nav-link text-primary" href="view/sign_up.php">S'inscrire</a>
          </li>
        <?php } else { ?>
          <a class="nav-link text-primary" href="view/profile_user.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
              <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
            </svg>
            <?= $_SESSION['name'] ?>
          </a>
        <?php } ?>
        <?php
        if (isset($_SESSION['user_isartist'])) {
          if ($_SESSION['user_isartist']) { ?>
            <li class="nav-item">
              <a href="view/upload_music.php?id=<?= $_SESSION['user_id'] ?>">Uploadez votre musique ici</a>
            </li>
        <?php }
        } ?>
        </ul>
      </div>

    </div>
    <script>
      function addDarkmodeWidget() {
        new Darkmode().showWidget();
      }
      window.addEventListener('load', addDarkmodeWidget);
    </script>
  </nav>