<?php 

class User
{
	protected $errors = [],
$id, 
$name,
$pseudo,
$email,
$password,
$active,
$created_at,
$city,
$country,
$sex,
$twitter,
$github,
$facebook,
$available_for_hiring,
$bio;


  public function __construct($valeurs = [])
  {
      $this->hydrate($valeurs);
  }
  
  
  // SETTERS //
  
  public function setId($id)
  {
    $this->id = (int) $id;
  }
  
  public function setAuteur($name)
  {
    if (!is_string($name) || empty($name))
    {
      $this->erreurs[] = self::NOM_INVALIDE;
    }
    else
    {
      $this->name = $name;
    }
  }
  
  public function setPseudo($pseudo)
  {
    if (!is_string($pseudo) || empty($pseudo))
    {
      $this->erreurs[] = self::PSEUDO_INVALIDE;
    }
    else
    {
      $this->pseudo = $pseudo;
    }
  }
  
  public function setEmail($email)
  {
    if (!is_string($email) || empty($email))
    {
      $this->erreurs[] = self::EMAIL_INVALIDE;
    }
    else
    {
      $this->email = $email;
    }
  }
  
  public function setPassword($password)
  {
    $this->password = $password;
  }
  
    public function setCreatedAt(DateTime $created_at)
  {
    $this->created_at = $created_at;
  }
  public function setCity($city)
  {
    $this->city = $city;
  }
  public function setCountry($country)
  {
    $this->country = $country;
  }
  public function setSex($sex)
  {
    $this->sex = $sex;
  }
  public function setTwiter($twitter)
  {
    $this->twitter = $twitter;
  }
  public function setGithub($github)
  {
    $this->github = $github;
  }
  public function setFacebook($facebook)
  {
    $this->facebook = $facebook;
  }
   public function setAvailable($available_for_hiring)
  {
    $this->available_for_hiring = $available_for_hiring;
  }
   public function setBio($bio)
  {
    $this->bio = $bio;
  }
  
  // GETTERS //
  
  public function errors()
  {
    return $this->errors;
  }
  
  public function id()
  {
    return $this->id;
  }
  
  public function name()
  {
    return $this->name;
  }
  
  public function pseudo()
  {
    return $this->pseudo;
  }
  
  public function email()
  {
    return $this->email;
  }
  
  public function password()
  {
    return $this->password;
  }
  
  public function active()
  {
    return $this->active;
  }
  public function created_at()
  {
    return $this->created_at;
  }
  public function city()
  {
    return $this->city;
  }
  public function country()
  {
    return $this->country;
  }
  public function sex()
  {
    return $this->sex;
  }
  public function twitter()
  {
    return $this->twitter;
  }
  public function github()
  {
    return $this->github;
  }
  public function facebook()
  {
    return $this->facebook;
  }
  public function available_for_hiring()
  {
    return $this->available_for_hiring;
  }
  public function bio()
  {
    return $this->bio;
  }
}
}