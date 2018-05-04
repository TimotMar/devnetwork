<?php
/*
*This file is used for checking the errors in case of registering
*
*
**/
session_start(); //as long as the session is not started, we can't use $session
//var_dump($_SESSION);
//die();
include('../controller/filter/guest_filter.php');//only guest can see register
require('../controller/includes/functions.php');
require('../model/config/database.php');
require('../controller/includes/constants.php');

// if form is submitted
if (isset($_POST['register'])) {
    //if all fields are filled
    if (not_empty(['name', 'pseudo', 'email', 'password', 'password_confirm'])) {
        $errors = []; // array with the errors

        extract($_POST); //access to $postname with name...

        if (mb_strlen($pseudo) < 3) {
            $errors[] = "Pseudo trop court ! (Minimum 3 caractères)";
        }
        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {//constant of php
            $errors[] = "Adresse email invalide!";
        }
        if (mb_strlen($password) < 6) {
            $errors[] = "Mot de passe trop court !(minimum 6 caractères)";
        } else {
            if ($password != $password_confirm) {
                $errors[] = "Les deux mots de passe ne concordent pas";
            }
        }
        if (is_already_in_use('pseudo', $pseudo, 'users')) {//verify unicity of pseudo
            $errors[] = "Pseudo déjà utilisé";
        }
        if (is_already_in_use('email', $email, 'users')) {
            $errors[] = "Adresse email déjà utilisée";
        }
        if (count($errors) == 0) {
            //send email activation
            $to = $email;
            $subject = WEBSITE_NAME. " - ACTIVATION DE COMPTE";
            $password = sha1($password);
            $token = sha1($pseudo.$email.$password);

            ob_start();
            require('../views/templates/emails/activation.tmpl.php');
            $content = ob_get_clean();
            //everything will be settled in temporary memory but not not display

            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

            mail($to, $subject, $content, $headers);

            //inform user to check mailbox
            set_flash("Mail d'activation envoyé", "danger");

            $q = $db->prepare('INSERT INTO users (name, pseudo, email, password) 
VALUES (:name, :pseudo, :email, :password)');
            $q ->execute([
                'name' => $name,
                'pseudo' => $pseudo,
                'email' => $email,
                'password' => $password

            ]);




            redirect('../index.php');
            exit();
        } else {
            save_input_data(); //save datas but need a function to recover them
        }
    } else {
        $errors[] = "Veuillez remplir tous les champs";
        save_input_data();
    }
} else {
    clear_input_data();
}
?>


<?php
require('../views/register.view.php');
