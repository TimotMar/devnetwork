<?php
/*
*This file is used for loading the pages only allowed to users logged
*
*
**/

if (!isset($_SESSION['user_id']) && !isset($_SESSION['pseudo'])) {
    $_SESSION['forwarding_url']=$_SERVER['REQUEST_URI'] ;
//we save in session the URl the user wanted to go to
    $_SESSION['notification']['message'] = 'Vous devez être connecté pour accéder à cette page';
    $_SESSION['notification']['type'] = 'danger';
    header('Location: ../../model/login.php'); // redirection
    exit();
}
