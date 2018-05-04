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
        $db = new \PDO('mysql:host=localhost;dbname=boom', 'root', 'TimPucelle:92');
        return $db;
    }
}