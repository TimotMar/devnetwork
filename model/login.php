<?php
/*
*This file is used for the login system page
*
*
**/
session_start(); // as long as the session is not started, we can't use $session
//var_dump($_SESSION);
//die();
include('../controller/filter/guest_filter.php'); // seul visiteur va voir login
require('../controller/includes/functions.php');
require('config/database.php');
require('../controller/includes/constants.php');

// if post
if (isset($_POST['login'])) {
    //if the fields have been filled
    if (not_empty(['identifiant', 'password'])) {
            extract($_POST); //access to all the variables into the post

            $q = $db->prepare("SELECT id, pseudo, email FROM users 
                                        WHERE (pseudo = :identifiant OR email = :identifiant) 
                                        AND password = :password AND active = '1'");
            $q->execute([
                'identifiant' => $identifiant,
                'password' => sha1($password)
            ]);
            //if user has been found : tell me how much of them you found
            $userHasBeenFound = $q->rowCount();
        if ($userHasBeenFound) {
                //we are allowed to recover datats because session is opened
                $user = $q->fetch(PDO::FETCH_OBJ);

                $_SESSION['user_id'] = $user->id; //storage of the id
                $_SESSION['pseudo'] = $user->pseudo;
                $_SESSION['email'] = $user->email;
                //we keep this as long as the session is active. user connected only if id and pseudo exist.
                redirect_intent_or('profile.php?id='.$user->id);
        } else {
                set_flash('Combinaison Identifiant/Password incorrecte', 'danger');
                save_input_data();
        }
    } else {
        clear_input_data();
    }
}
?>


<?php
require('../views/login.view.php');

