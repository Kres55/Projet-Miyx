<?php

include "base.php";
include "message.php";
include "../controller/pdo.php";


?>
<main style="height: 100vh">
    <h1 class="text-center mt-5 text-primary">Connexion</h1>

    <div class="text-center align-items-center d-flex">
        <form class="w-50 mx-auto border border-3 border-primary rounded-2 shadow-lg p-3 mb-5 mt-5 " action="controller/login_controller.php" method="POST">

            <label class="form-label my-4 " for="user_mail">Email de connexion</label>

            <input type="mail" class="form-control mx-auto w-50" name="user_mail">

            <label class="form-label my-4 " for="user_password">Mot de passe</label>

            <input class="form-control mx-auto w-50" type="password" name="user_password">

            <div class="mx-auto my-4">
                <input class="btn btn-primary" type="submit" value="Connexion">
            </div>

            <div class="text-center">
                <p>Pas encore inscrit ? <a href="view/sign_up.php">Inscrivez-vous ici</a></p>
            </div>
        </form>





    </div>
</main>



</body>

</html>