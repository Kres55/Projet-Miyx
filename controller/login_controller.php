<?php
include "pdo.php";


    if (!empty($_POST['user_mail']) && !empty($_POST['user_password'])) {

        $mail = $_POST['user_mail'];
        $sql = "SELECT * FROM users WHERE user_mail=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$mail]);
        $user= $stmt->fetch(PDO::FETCH_ASSOC);

        if($user){
            if(password_verify($_POST['user_password'], $user['user_password'])){
                session_start();
                $_SESSION['name'] = $user['user_lastname'];
                $_SESSION['token'] = bin2hex(random_bytes(16));
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['user_isartist'] = $user['user_isartist'];

                header("Location: ../view/homepage.php"); 
            }else{
                header("Location: login.php?message=Identifiants incorrectes1.&status=error"); 
            }

        }else{
            header("Location: login.php?message=Identifiants incorrectes2.&status=error"); 
        }

    }else{
        header("Location: login.php?message=Entrez vos identifiants correctement.&status=error");
    }



?>