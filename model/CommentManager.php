<?php
/*
*This file is used for connections to the DB for the comment system
*Using POO
*
**/

namespace Devnetwork\Blog\Model;

require_once("Manager.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '/var/www/devnetwork/vendor/autoload.php';

class CommentManager extends Manager
{
    //recovering of the comments
    public function getComments($postId)
    {
        $db = $this->dbConnect();
        $comments = $db->prepare('SELECT id, author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') 
AS comment_date_fr, publication FROM comments WHERE post_id = ? ORDER BY comment_date DESC');
        $comments->execute(array($postId));

        return $comments;
    }
    //funciton used to post the comment connected to the post
    public function postComment($postId, $author, $comment, $post_mail, $post_pseudo)
    {
        $db = $this->dbConnect();
        extract($_POST);
        $mail = new PHPMailer(true);
        try {
            $mail->SMTPDebug = 2;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'tim.marissal@gmail.com';
            $mail->Password = '174103392';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            $mail->setFrom('tim.marissal@gmail.com', 'Tim-dev.com');
            $mail->addAddress($post_mail, $post_pseudo);
            $mail->isHTML(true);
            $mail->Subject = 'Validation de commentaire';
            $mail->Body = "Un client a déposé un commentaire sur votre article. Afin de le valider ou le supprimer, veuillez cliquer sur ce lien : <a href='http://devnetwork.tim-dev.fr/index.post.php?action=post&id=$postId'> Lien de validation </a>";
            $mail->send();
        
        set_flash("Commentaire posté avec succés, veuillez attendre la validation par l'admin", "success");
//inform user to check mailbox
        $comments = $db->prepare("INSERT INTO comments(post_id, author, comment, comment_date, post_mail, post_pseudo) VALUES(?, ?, ?, NOW(), ?, ?)");
        $affectedLines = $comments->execute(array($postId, $author, $comment, $post_mail, $post_pseudo));

        return $affectedLines;
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
    }
    //function used to delete comments
    public function deleteComment($id)
    {
        $db = $this->dbConnect();
        $contents = $db->prepare("DELETE FROM comments WHERE id=:id");
        $affectedComments = $contents->execute(array('id'=>$id));

        return $affectedComments;
    }
    //functions sued in the validation system to activate or not the comment
    public function validateComment($id)
    {
        $db = $this->dbConnect();
        $contents = $db->prepare("UPDATE comments SET publication='1' WHERE id=:id");
        $affectedComments = $contents->execute(array('id'=>$id));

        return $affectedComments;
    }
}