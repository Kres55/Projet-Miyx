<?php
include "base.php";
include "message.php";
include "../controller/pdo.php";

//$sql = "SELECT id_user, firstname_user, lastname_user, mail_user, role_user, subject_user, image_user FROM user";

$id = $_SESSION['user_id'];
$sql = "SELECT user_lastname, user_firstname, user_mail, user_avatar FROM users WHERE user_id = '$id'";
$stmt = $pdo->query($sql);
$users = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<h1 class="text-center">Votre Profil</h1>

<div class="container-fluid border border-2 col-10 mt-5 rounded-2">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="tab1-tab" data-bs-toggle="tab" data-bs-target="#tab1" type="button" role="tab" aria-controls="tab1" aria-selected="true">Mes informations</button>
        </li>
    </ul>
    <div class="tab-content mt-3" id="myTabContent">
        <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
            <!-- Affichage de l'avatar -->
            <?php if (!empty($users['user_avatar'])): ?>
                <div class="text-center mb-3">
                    <img src="avatars/<?= htmlentities($users['user_avatar']) ?>" alt="Avatar" class="rounded-circle" width="120" height="120">
                </div>
            <?php endif; ?>
            <!-- Bouton pour changer l'avatar -->
            <div class="text-center mb-3">
                <a href="view/update_avatar_form.php" class="btn btn-outline-primary">Changer mon avatar</a>
            </div>
            <ul class="list-unstyled text-center">
                <li>
                    Nom : <span><?= htmlentities($users['user_lastname']) ?> </span>
                </li>
                <li>
                    Prenom : <?= htmlentities($users['user_firstname']) ?>
                </li>
                <li>
                    Mail : <?= htmlentities($users['user_mail']) ?>
                </li>
            </ul>
            <div class="text-center">
                <a href="view/modify_user.php" class="btn btn-primary mt-5 me-5">Modifier</a>
                <a href="controller/delete_user_controller.php?id=<?= $id ?>" class="btn btn-danger delete_btn mt-5" data-bs-toggle="modal" data-bs-target="#validation_delete">Supprimer votre compte</a>
            </div>
        </div>
    </div>
</div>
</div>
<div class="row">
    <div class="col-lg-12 text-center">


    </div>

</div>
</div>

<div class="modal" id="validation_delete" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Supression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Voulez vous vraiment supprimer votre compte ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Non</button>
                <a id="delete" href="" class="btn btn-danger">Supprimer</a>
            </div>
        </div>
    </div>
</div>

<script>
    const btnDelete = document.getElementById('delete')
    const deleteLinks = document.querySelectorAll(".delete_btn")

    for (deleteLink of deleteLinks) {
        deleteLink.addEventListener('click', function() {

            let href = this.href;
            btnDelete.href = href;

        });
    }
</script>

</body>

</html>