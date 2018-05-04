<?php
/*
*This file is used for editing your using content page
*
*
**/
session_start();

include('../controller/filter/user_filter.php'); //we set the page only if the user is connected
require('config/database.php');
require("../controller/includes/functions.php");
require('../controller/includes/constants.php');


if (!empty($_GET['id']) && $_GET['id'] === get_session('user_id')) {
    //recovery of the user information in the DB using the ID
    $user = find_user_by_id($_GET['id']);

    if (!$user) {
        redirect('../index.php');
    }
} else {
    redirect('profile.php?id='.get_session('user_id')); // redirection with the good id
}


if (isset($_POST['update'])) {
    $errors = [];//if all the fields are filled
    if (not_empty(['name', 'city', 'country', 'sex', 'bio'])) {
        extract($_POST); //let you get all the variables included into the post

        $q = $db->prepare("UPDATE users SET name = :name, city = :city, 
country = :country, sex = :sex, twitter = :twitter, github = :github, facebook = :facebook, 
available_for_hiring = :available_for_hiring, bio = :bio WHERE id = :id");
        $q->execute([
            'name' => $name,
            'city' => $city,
            'country' => $country,
            'sex' => $sex,
            'twitter' => $twitter,
            'github' => $github,
            'facebook' => $facebook,
            'available_for_hiring' => !empty($available_for_hiring) ? '1' : '0', // if not empty : checked, so value =1, else : 0
            'bio' => $bio,
            'id' => get_session('user_id')
        ]);
        set_flash("Votre profil a été mis à jour");
        redirect('profile.php?id='.get_session('user_id'));
    } else {
        save_input_data();
        $errors[] = "Veuillez remplir tous les champs marqués d'un *";
    }
} else {
    clear_input_data();
}

require("../views/edit_user.view.php");
