<?php
/*
*This file is used for the logout system
*With the redirection to the login page
*
**/
session_start();
session_destroy();

$_SESSION = []; // emptying the array

header('Location: ../model/login.php');
