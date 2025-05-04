<?php
include "base.php";
include "message.php";
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<h2 class="text-center text-primary mt-4">Changer mon avatar</h2>

<form class="w-50 mx-auto mt-4 border p-3 rounded-2 shadow-lg" action="controller/update_avatar_controller.php" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="avatar" class="form-label">Choisir une image (jpg/png ou gif si premium)</label>
        <input class="form-control" type="file" name="avatar" id="avatar" accept=".jpg,.jpeg,.png,.gif" required>
    </div>
    <div class="text-center">
        <input class="btn btn-primary" type="submit" value="Mettre à jour l’avatar">
    </div>
</form>
