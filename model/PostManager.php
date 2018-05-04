<?php
/*
*This file is used for managing of all the functions connected to the DB in the blog post system
*Using POO
*
**/

namespace Devnetwork\Blog\Model;

require_once("Manager.php");

class PostManager extends Manager
{
    public function getPosts()
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') 
AS creation_date_fr, pseudonyme, chapo FROM posts ORDER BY creation_date DESC LIMIT 0, 5');

        return $req;
    }

    public function getPost($postId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') 
AS creation_date_fr, pseudonyme, chapo FROM posts WHERE id = ?');
        $req->execute(array($postId));
        $post = $req->fetch();

        return $post;
    }

    public function postPost($title, $content, $pseudonyme, $chapo)
    {
        $db = $this->dbConnect();
        $contents = $db->prepare('INSERT INTO posts(title, content, creation_date, pseudonyme, chapo) VALUES(?, ?, NOW(), ?, ?)');
        $affectedPosts = $contents->execute(array($title, $content, $pseudonyme, $chapo));

        return $affectedPosts;
    }

    public function modifierPost($id, $title, $content, $pseudonyme, $chapo)
    {
        $db = $this->dbConnect();
        $contents = $db->prepare("UPDATE posts SET title=:title, content=:content, creation_date=NOW(), pseudonyme=:pseudonyme, chapo=:chapo WHERE id=:id");
        $affectedPosts = $contents->execute(array('id'=>$id, 'title'=>$title, 'content'=>$content, 'pseudonyme'=>$pseudonyme, 'chapo'=>$chapo));

        return $affectedPosts;
    }

    public function deletePost($id)
    {
        $db = $this->dbConnect();
        $contents = $db->prepare("DELETE FROM posts WHERE id=:id");
        $affectedPosts = $contents->execute(array('id'=>$id));

        return $affectedPosts;
    }
}