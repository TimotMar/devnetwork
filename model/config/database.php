<?php
/*
*This file is used for connections to the DB for the all system
*Including constants
*
**/
//DB credentials
define('DB_HOST', 'localhost');
define('DB_NAME', 'boom');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'TimPucelle:92');

try {
    $db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USERNAME, DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//If exception : stop. Else : continue
    $db->query('SELECT * FROM users');
} catch (PDOException $e) {
    die('Erreur:'.$e->getMessage());
}
