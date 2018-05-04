<?php
/*
*This file is used for connections to the DB for the comment system
*Using POO
*
**/
namespace Devnetwork\Blog\Model;

require_once("Manager.php");

class CommentManager extends Manager
{
    public function getComments($postId)
    {
        $db = $this->dbConnect();
        $comments = $db->prepare('SELECT id, author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') 
AS comment_date_fr, publication FROM comments WHERE post_id = ? ORDER BY comment_date DESC');
        $comments->execute(array($postId));

        return $comments;
    }

    public function postComment($postId, $author, $comment)
    {
        $db = $this->dbConnect();
        $comments = $db->prepare('INSERT INTO comments(post_id, author, comment, comment_date, publication) VALUES(?, ?, ?, NOW()), 0');
        $affectedLines = $comments->execute(array($postId, $author, $comment));

        return $affectedLines;
    }

    public function deleteComment($id)
    {
        $db = $this->dbConnect();
        $contents = $db->prepare("DELETE FROM comments WHERE id=:id");
        $affectedComments = $contents->execute(array('id'=>$id));

        return $affectedComments;
    }
}