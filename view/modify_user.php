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

<form class="w-50 mx-auto" action="../controller/modify_user_controller.php" method="POST">


    <label class="form-label" for="firstname_user">Prénom</label>
    <input class="form-control" type="text" name="firstname_user" value="<?= htmlentities($user['user_firstname']) ?>" placeholder="Prénom de l'employé">


    <label class="form-label" for="lastname_user">Nom</label>
    <input class="form-control" type="text" name="lastname_user" value="<?= htmlentities($user['user_lastname']) ?>" placeholder="Nom de l'employé">


    <label class="form-label" for="mail_user">Courriel</label>
    <input class="form-control" type="text" name="mail_user" value="<?= htmlentities($user['user_mail']) ?>" placeholder="Email de l'employé">

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