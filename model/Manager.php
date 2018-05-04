<?php
/*
*This file is used for  managing the Db connection to posts and comments
*Using POO
*
**/
//
namespace Devnetwork\Blog\Model;

class Manager
{
    protected function dbConnect()
    {
        define('DB_HOST', 'localhost');
        define('DB_NAME', 'boom');
        define('DB_USERNAME', 'root');
        define('DB_PASSWORD', 'TimPucelle:92');
        $db = new \PDO('mysql:host=localhost;dbname=boom', 'root', 'TimPucelle:92');
        return $db;
    }
}