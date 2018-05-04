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
AS creation_date_fr, pseudo, chapo FROM posts ORDER BY creation_date DESC LIMIT 0, 5');

        return $req;
    }

    public function getPost($postId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') 
AS creation_date_fr, pseudo, chapo, post_mail FROM posts WHERE id = ?');
        $req->execute(array($postId));
        $post = $req->fetch();

        return $post;
    }

    public function postPost($title, $content, $chapo, $pseudo, $post_mail)
    {
        $db = $this->dbConnect();
        $contents = $db->prepare('INSERT INTO posts(title, content, creation_date, chapo, pseudo, post_mail) VALUES(?, ?, NOW(), ?, ?, ?)');
        $affectedPosts = $contents->execute(array($title, $content, $chapo, $pseudo, $post_mail));

        return $affectedPosts;
    }

    public function modifierPost($id, $title, $content, $chapo, $pseudo)
    {
        $db = $this->dbConnect();
        $contents = $db->prepare("UPDATE posts SET title=:title, content=:content, creation_date=NOW(), chapo=:chapo, pseudo=:pseudo WHERE id=:id");
        $affectedPosts = $contents->execute(array('id'=>$id, 'title'=>$title, 'content'=>$content, 'chapo'=>$chapo, 'pseudo'=>$pseudo));

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