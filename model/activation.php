<?php
/*
*This file is used for the activation of the account
*with some requests for the DB
*
**/
session_start();
include('../controller/filter/guest_filter.php'); //only guest can see activation.php
require('../model/config/database.php');
require('../controller/includes/functions.php');

if(!empty($_GET['p']) && is_already_in_use('pseudo', $_GET['p'], 'users') && !empty($_GET['token'])) //if get p exists and is in the DB : we continue
{
    $pseudo = $_GET['p'];
    $token = $_GET['token'];

    $q = $db->prepare('SELECT email, password FROM users WHERE pseudo = ?');
    $q->execute([$pseudo]);



    $data = $q->fetch(PDO::FETCH_OBJ); // recovery of the informations of the request as an object

    $token_verif = sha1($pseudo.$data->email.$data->password);
    if ($token == $token_verif) {
        $q = $db->prepare("UPDATE users SET active = '1' WHERE pseudo = ?");
        $q->execute([$pseudo]);

        redirect('../model/login.php');
    } else {
        set_flash('Paramètres invalides', 'danger');
        redirect('../index.php');
}
} else {
    redirect('../index.php');
}