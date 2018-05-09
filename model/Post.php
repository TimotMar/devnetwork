<?php 

class Post
{
	protected $errors = [],
$id, 
$title,
$content,
$creation_date,
$chapo,
$pseudo,
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
  
  public function setTitle($title)
  {
    $this->title = $title;
  }
   public function setContent($content)
  {
    $this->content = $content;
  }
    public function setCreationdate(DateTime $creation_date)
  {
    $this->creation_date = $creation_date;
  }
  public function setChapo($chapo)
  {
    $this->chapo = $chapo;
  }
  public function setPseudo($pseudo)
  {
    $this->pseudo = $pseudo;
  }
  public function setPostmail($post_mail)
  {
    $this->post_mail = $post_mail;
  }

  // GETTERS //
  
  public function id()
  {
    return $this->id;
  }
  
  public function title()
  {
    return $this->title;
  }
  
  public function content()
  {
    return $this->content;
  }
  
  public function creation_date()
  {
    return $this->creation_date;
  }
  
  public function chapo()
  {
    return $this->chapo;
  }
  
  public function pseudo()
  {
    return $this->pseudo;
  }
  public function post_mail()
  {
    return $this->post_mail;
  }
}