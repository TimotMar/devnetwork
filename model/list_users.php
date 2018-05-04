<?php
/*
*This file is used to load the list_user page
*
*
**/
session_start();
//connection to the DB to select the users datas
require('config/database.php');
require("../controller/includes/functions.php");
require('../controller/includes/constants.php');

$q = $db->query("SELECT id, pseudo, email FROM users WHERE active='1' ORDER BY pseudo");
$users = $q->fetchAll(PDO::FETCH_OBJ);



require("../views/list_users.view.php");
