<?php session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" integrity="sha384-tViUnnbYAV00FLIhhi3v/dWt3Jxw4gZQcNoSCxCIFNJVCx7/D55/wXsrNIRANwdD" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/darkmode-js@1.5.7/lib/darkmode-js.min.js"></script>
  <link rel="stylesheet" href="../css/style.css">
  <title>Miyx - Ecoutez de la musique indépendante gratuitement</title>
</head>

<body class="bg-body-dark">
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="homepage.php">Miyx</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- Barre de recherche centrée (visible en version mobile, sans bouton) -->
      <form class="d-flex d-lg-none mx-auto my-2" role="search">
        <input class="form-control me-2" type="search" placeholder="titre, artiste, genre..." aria-label="Search">
      </form>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle='dropdown' aria-expanded="false">
              Recherchez par...
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item text-center" href="#">Artiste</a></li>
              <li><a class="dropdown-item text-center" href="#">Genre</a></li>
              <li><a class="dropdown-item text-center" href="#">Titre</a></li>
            </ul>
          </li>
          <?php if (!isset($_SESSION['name'])) { ?>
            <li class="nav-item">
              <a class="nav-link text-primary" href="login.php">Connexion</a>
            </li>
          <?php } else { ?>
            <li class="nav-item">
              <a class="nav-link text-primary" href="../controller/logout.php">Déconnexion</a>
            </li>
          <?php } ?>

          <li class="nav-item">
            <a class="nav-link disabled" aria-disabled="true">Premium</a>
          </li>

          <li class="nav-item">
            <?php if (!isset($_SESSION['name'])) { ?>
              <a class="nav-link text-primary" href="sign_up.php">S'inscrire</a>
          </li>
        <?php } else { ?>
          <a class="nav-link text-primary" href="profile_user.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
              <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
            </svg>
            <?= $_SESSION['name'] ?>
          </a>
        </ul>
      <?php } ?>

      <!-- Barre de recherche pour version bureau -->
      <form class="d-none d-lg-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="titre, artiste, genre..." aria-label="Search">
      </form>
      </div>

    </div>
    <script>
      function addDarkmodeWidget() {
        new Darkmode().showWidget();
      }
      window.addEventListener('load', addDarkmodeWidget);
    </script>
  </nav>