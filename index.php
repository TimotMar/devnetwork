<?php
/*
*This file is the index of the website
*It is used to user every functions linked to the website
*
**/
session_start();
include('controller/includes/constants.php');
require("controller/backend.php");
require('controller/frontend.php');

try {
    if (isset($_GET['action'])) {
        if ($_GET['action'] == 'liste') {
            liste();
        } elseif ($_GET['action'] == 'logout') {
            session_destroy();
            $_SESSION = []; // emptying the array
            accueil();
        } elseif ($_GET['action'] == 'inscription') {
                inscription();
        } elseif ($_GET['action'] == 'register') {
            if (!empty($_POST['name']) && !empty($_POST['pseudo']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['password_confirm']) && !empty($_POST['country']) && !empty($_POST['city'])){
                register($_POST['name'], $_POST['pseudo'], $_POST['email'], $_POST['password'], $_POST['password_confirm'], $_POST['city'], $_POST['country']);
            }
        } elseif ($_GET['action'] == 'change') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                change();
            } else {
                throw new Exception('Aucun compte trouvé, veuillez vous identifier');
            }
        } elseif ($_GET['action'] == 'changeUser') {
            if (!empty($_POST['name']) && !empty($_POST['city']) && !empty($_POST['country'])) {
                changeUser($_GET['id'], $_POST['name'], $_POST['city'], $_POST['country'], $_POST['sex'], $_POST['twitter'], $_POST['github'], $_POST['facebook'], $_POST['available_for_hiring'], $_POST['bio']);
            } else {
                throw new Exception('Tous les champs ne sont pas remplis !');
            }
        } elseif ($_GET['action'] == 'activation') {
            if (!empty($_GET['p']) && is_already_in_use('pseudo', $_GET['p'], 'users') && !empty($_GET['token'])) { //if get p exists and is in the DB : we continue
                activation();
            } else {
                redirect('index.php');
            }
        } elseif ($_GET['action'] == 'profile') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                profile();
            } else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        } elseif ($_GET['action'] == 'login') {
            login();
        } elseif ($_GET['action'] == 'logintheUser') {
            if (!empty($_POST['identifiant']) && !empty($_POST['password'])) {
                logintheUser($_POST['identifiant'], $_POST['password']);
            } else {
                set_flash('Combinaison Identifiant/Password incorrecte', 'danger');
                save_input_data();
            }
        } else {
            clear_input_data();
        }
    } else {
        accueil();
    }
} catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}