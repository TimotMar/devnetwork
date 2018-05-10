<?php
/*
*This file is used for managing of all the functions connected to the DB in the user system
*Using POO
*
**/

namespace Devnetwork\Blog\Model;

require_once("Manager.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '/var/www/devnetwork/vendor/autoload.php';

class UserManager extends Manager
{
    //function used to modify the users datas
    public function modifierUser($id, $name, $city, $country, $sex, $twitter, $github, $facebook, $available_for_hiring, $bio)
    {
        $db = $this->dbConnect();
        $contenu = $db->prepare('UPDATE users SET name=:name, city=:city, country=:country, sex=:sex, twitter=:twitter, github=:github, facebook=:facebook, available_for_hiring=:available_for_hiring, bio=:bio WHERE id=:id');
        $affectedUser = $contenu->execute(array('id' => $id, 'name' => $name, 'city' => $city, 'country' => $country, 'sex' => $sex, 'twitter' => $twitter, 'github' => $github, 'facebook' => $facebook, 'available_for_hiring' => $available_for_hiring, 'bio' => $bio));

        return $affectedUser;
    }
    //function used to recover datas linked to a special profile
    public function getProfile($id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, name, pseudo, email, city, country, sex, twitter, github, facebook, available_for_hiring, bio FROM users WHERE id = ?');
        $req->execute(array($id));
        $profile = $req->fetch();

        return $profile;
    }
    //functions used to select all the users from DB
    public function getListe()
    {
        $db = $this->dbConnect();
        $req = $db->query("SELECT id, pseudo, email FROM users WHERE active='1' ORDER BY pseudo");

        return $req;
    }
    //function used to save datas of the registration + mailing 
    public function registerUser($name, $pseudo, $email, $password, $password_confirm, $country, $city)
    {
        $db = $this->dbConnect();
        $errors = []; // array with the errors

        extract($_POST); //access to $postname with name...

        if (strlen($pseudo) < 3) {
            $errors[] = "Pseudo trop court ! (Minimum 3 caractères)";
        }
        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {//constant of php
            $errors[] = "Adresse email invalide!";
        }
        if (strlen($password) < 6) {
            $errors[] = "Mot de passe trop court !(minimum 6 caractères)";
        } else {
            if ($password != $password_confirm) {
                $errors[] = "Les deux mots de passe ne concordent pas";
            }
        }
        if (is_already_in_use('pseudo', $pseudo, 'users')) {//verify unicity of pseudo
            $errors[] = "Pseudo déjà utilisé";
            set_flash("Pseudo déjà utilisé", "danger");
        }
        if (is_already_in_use('email', $email, 'users')) {
            $errors[] = "Adresse email déjà utilisée";
            set_flash("Adresse email déjà utilisée", "danger");
        }
        if (count($errors) == 0) {
            //send email activation
            $password=sha1($password);
            $token = sha1($pseudo.$email.$password);
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
                $mail->addAddress($email, $name);
                $mail->isHTML(true);
                $mail->Subject = 'Validation de l\'incription';
                $mail->Body    = "Veuillez cliquer sur ce lien pour valider l'incription : <a href='http://devnetwork.tim-dev.fr/index.php?action=activation&amp;p=$pseudo&amp;token=$token'>Lien d'activation</a>";
                $mail->send();
            } catch (Exception $e) {
                echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
            }
            //inform user to check mailbox
            set_flash("Mail d'activation envoyé", "danger");
            $datauser = $db->prepare('INSERT INTO users(name, pseudo, email, password, country, city) VALUES (?, ?, ?, ?, ?, ?)');
            $datauser ->execute(array($name,$pseudo,$email,$password,$country,$city));
            return $datauser;
        }
    }  
    //function used to connect the login system to the DB 
    public function loginUser($identifiant, $password)
    {
        $db = $this->dbConnect();
        extract($_POST); //access to all the variables into the post

            $q = $db->prepare("SELECT id, pseudo, email FROM users 
                                        WHERE (pseudo = :identifiant OR email = :identifiant) 
                                        AND password = :password AND active = '1'");
            $q->execute([
                'identifiant' => $identifiant,
                'password' => sha1($password)
            ]);
            //if user has been found : tell me how much of them you found
            $userHasBeenFound = $q->rowCount();
        if ($userHasBeenFound) {
                //we are allowed to recover datats because session is opened
                $user = $q->fetch(\PDO::FETCH_OBJ);

                $_SESSION['user_id'] = $user->id; //storage of the id
                $_SESSION['pseudo'] = $user->pseudo;
                $_SESSION['email'] = $user->email;
                //we keep this as long as the session is active. user connected only if id and pseudo exist.
                redirect_intent_or('index.php?action=profile&id='.$user->id);
        } else {
                set_flash('Combinaison Identifiant/Password incorrecte', 'danger');
                save_input_data();
        }
    }
    //function used to recover the token from the activation's mail to activate the account
    public function activationUser()
    {
        $db = $this->dbConnect();
        $pseudo = $_GET['p'];
        $token = $_GET['token'];

        $q = $db->prepare('SELECT email, password FROM users WHERE pseudo = ?');
        $q->execute([$pseudo]);

        $data = $q->fetch(\PDO::FETCH_OBJ); // recovery of the informations of the request as an object

        $token_verif = sha1($pseudo.$data->email.$data->password);
        if ($token == $token_verif) {
            set_flash('Compte activé avec succès!', 'danger');
            $q = $db->prepare("UPDATE users SET active = '1' WHERE pseudo = ?");
            $q->execute([$pseudo]);
            return $q;
        } else {
            set_flash('Paramètres invalides', 'danger');
            redirect('index.php');
        }
    }
}
