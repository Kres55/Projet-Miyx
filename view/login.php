<?php

include "base.php";
include "message.php";
include "../controller/pdo.php";


?>
<main style="height: 100vh">
    <h1 class="text-center mt-5">Miyx</h1>

    <div class="text-center align-items-center d-flex">
        <form class="w-50 mx-auto bg-secondary border rounded" action="../controller/login_controller.php" method="POST">

            <label class="form-label my-4 text-white" for="user_mail">Email de connexion</label>

            <input type="mail" class="form-control mx-auto w-50" name="user_mail">

            <label class="form-label my-4 text-white" for="user_password">Mot de passe</label>

            <input class="form-control mx-auto w-50" type="password" name="user_password">

            <div class="mx-auto my-4">
                <input class="btn btn-primary" type="submit" value="Connexion">
            </div>

        </form>
    </div>
</main>



</body>

</html>