<?php
include "base.php";
include 'message.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

?>
<h1 class="text-center text-primary">Modifier mon mot de passe</h1>

<form class="w-50 mx-auto" action="controller/update_psw_user_controller.php" method="POST">

    <!-- Ancien mot de passe -->

    <label class="form-label" for="old_psw_user">Ancien mot de passe</label>

    <input class="form-control" type="password" name="old_psw_user" placeholder="Ancien mot de passe">

    <!-- Nouveau mot de passe -->

    <label class="form-label" for="user_password">Nouveau mot de passe</label>

    <input class="form-control" type="password" name="user_password" placeholder="Nouveau mot de passe">


    <div class="text-center">
        <input type="submit" value="Mise à jour du mot de passe" class="btn btn-primary my-3">
    </div>

</form>


</body>

</html>