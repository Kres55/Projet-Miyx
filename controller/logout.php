<?php

session_start();
session_destroy();
//unset($_SESSION['name']); est inutile car les données de session sont détruites
header('Location: ../view/homepage.php');
exit();
