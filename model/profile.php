<?php
/*
*This file is used for loading your profile page
*recovering of the user data in DB using Id
*
**/
session_start();

require('../controller/includes/constants.php');
require("../controller/includes/functions.php");
include('../controller/filter/user_filter.php'); // we see page only if user is logged in
require('config/database.php');




if (!empty($_GET['id'])) {
    $user = find_user_by_id($_GET['id']);

    if (!$user) {
        redirect('index.php');
    }
} else {
    redirect('profile.php?id='.get_session('user_id')); // redirection with correct id
}

require("../views/profile.view.php");
