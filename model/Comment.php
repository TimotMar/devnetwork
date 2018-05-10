<?php 

class Comment
{
	protected $errors = [],
$id, 
$title,
$content,
$creation_date,
$chapo,
$post_pseudo,
$post_mail;

  public function __construct($valeurs = [])
  {
      $this->hydrate($valeurs);
  }
  
  
  // SETTERS //
  
  public function setId($id)
  {
    $this->id = (int) $id;
  }
  public function setPostid($post_id)
  {
    $this->post_id = $post_id;
  }
   public function setAuthor($author)
  {
    $this->author = $author;
  }
    public function setComment($comment)
  {
    $this->comment = $comment;
  }
    public function setCommentdate(DateTime $comment_date)
  {
    $this->comment_date = $comment_date;
  }
  public function setPublication($publication)
  {
    $this->publication = $publication;
  }
  public function setPostmail($post_mail)
  {
    $this->post_mail = $post_mail;
  }
  public function setPostpseudo($post_pseudo)
  {
    $this->post_pseudo = $post_pseudo;
  }

  // GETTERS //
  
  public function id()
  {
    return $this->id;
  }
  
  public function post_id()
  {
    return $this->post_id;
  }
  
  public function author()
  {
    return $this->author;
  }
  
  public function comment()
  {
    return $this->comment;
  }
  
  public function comment_date()
  {
    return $this->comment_date;
  }
  
  public function publication()
  {
    return $this->publication;
  }
  public function post_mail()
  {
    return $this->post_mail;
  }
   public function post_pseudo()
  {
    return $this->post_pseudo;
  }
}