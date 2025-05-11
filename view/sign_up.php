<?php
include "base.php";
include 'message.php';
?>
<h1 class="text-center text-primary mt-5">Inscription</h1>

<!-- La propriété action d'un formulaire
     permet de faire pointer les données de validation du formulaire vers un autre fichier où ils seront traitées. -->

<!-- POST est une méthode HTTP(Hypertext transfert protocol) qui envoie les données au serveur, contraire à la methode GET qui envoie les données dans l'URL -->

<form class="w-50 mx-auto border border-3 border-primary rounded-2 shadow-lg p-3 mb-5 mt-5" action="controller/add_user_controller.php" method="POST" enctype="multipart/form-data">


    <label class="form-label" for="user_firstname">Prénom</label>
    <input class="form-control" type="text" name="user_firstname" placeholder="Entrez votre prénom">

    <label class="form-label mt-4" for="user_lastname">Nom</label>
    <input class="form-control" type="text" name="user_lastname" placeholder="Entrez votre Nom">

    <label class="form-label mt-4" for="user_mail">Courriel</label>
    <input class="form-control" type="text" name="user_mail" placeholder="Entrez votre adresse mail ici">

    <label class="form-label mt-4" for="user_password">Mot de passe</label>
    <input class="form-control" type="password" name="user_password" placeholder="Entrez votre mot de passe">

    <p class="text-center">êtes vous un artiste ? </p>

    <div class="d-flex justify-content-center gap-4">
        <div>
            <input type="radio" id="artist" name="artist" value="yes">
            <label for="artist">Oui</label>
        </div>
        <div>
            <input type="radio" id="not_artist" name="artist" value="no" checked>
            <label for="not_artist">Non</label>
        </div>
    </div>

    <label class="form-label mt-4" for="user_lastname">Si oui quel est votre nom de scène?</label>
    <input class="form-control" type="text" name="user_artistname" placeholder="Entrez votre Nom de scene">

    <div class="text-center">
        <input type="submit" value="S'inscrire" class="btn btn-primary my-3">
    </div>

    <div class="text-center">
        <p>En vous inscrivant, vous acceptez nos <a href="view/condition_utilisation.php">Conditions d'utilisation</a> et notre <a href="view/politique_confidentialite.php">Politique de confidentialité</a>.</p>
    </div>

</form>


<div class="text-center">
    <p>Déjà inscrit ? <a href="view/login.php">Connectez-vous ici</a></p>
</div>




</body>

</html>