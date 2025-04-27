<?php
include "base.php";
include 'message.php';
include "../controller/pdo.php";


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$id = $_SESSION['user_id'];
$sql = "SELECT user_firstname, user_lastname, user_mail FROM users WHERE user_id = '$id'";
$stmt = $pdo->query($sql);
$user = $stmt->fetch(PDO::FETCH_ASSOC);


?>
<h1 class="text-center text-primary">Modifier mon profil</h1>

<form class="w-50 mx-auto" action="controller/modify_user_controller.php" method="POST">


    <label class="form-label" for="user_firstname">Prénom</label>
    <input class="form-control" type="text" name="user_firstname" value="<?= htmlentities($user['user_firstname']) ?>" placeholder="Votre nom">


    <label class="form-label" for="user_lastname">Nom</label>
    <input class="form-control" type="text" name="user_lastname" value="<?= htmlentities($user['user_lastname']) ?>" placeholder="Votre prénom">


    <label class="form-label" for="user_mail">Courriel</label>
    <input class="form-control" type="text" name="user_mail" value="<?= htmlentities($user['user_mail']) ?>" placeholder="Votre email">

    <div class="text-center my-3">
        <a class="btn btn-warning" href="view/psw_update_form.php">Modifier le mot de passe</a>
    </div>

    <!-- <div class="text-center my-3">
        <a class="btn btn-warning" href="view/image_update_form.php">Modifier la photo de profile</a>
    </div> -->

    <div class="text-center">
        <input type="submit" value="Mise à jour" class="btn btn-primary my-3">
    </div>

</form>


</body>

</html>