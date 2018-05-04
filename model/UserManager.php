<?php
/*
*This file is used for managing of all the functions connected to the DB in the blog post system
*Using POO
*
**/

namespace Devnetwork\Blog\Model;

require_once("Manager.php");

class UserManager extends Manager
{
    public function modifierUser($id, $name, $city, $country, $sex, $twitter, $github, $facebook, $available_for_hiring, $bio)
    {
        $db = $this->dbConnect();
        $contenu = $db->prepare('UPDATE users SET name=:name, city=:city, country=:country, sex=:sex, twitter=:twitter, github=:github, facebook=:facebook, available_for_hiring=:available_for_hiring, bio=:bio WHERE id=:id');
        $affectedUser = $contenu->execute(array('id' => $id, 'name' => $name, 'city' => $city, 'country' => $country, 'sex' => $sex, 'twitter' => $twitter, 'github' => $github, 'facebook' => $facebook, 'available_for_hiring' => $available_for_hiring, 'bio' => $bio));

        return $affectedUser;
    }

    public function getProfile($id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, name, pseudo, email, city, country, sex, twitter, github, facebook, available_for_hiring, bio FROM users WHERE id = ?');
        $req->execute(array($id));
        $profile = $req->fetch();

        return $profile;
    }

    public function getListe()
    {
        $db = $this->dbConnect();
        $req = $db->query("SELECT id, pseudo, email FROM users WHERE active='1' ORDER BY pseudo");

        return $req;
    }

    public function registerUser($name, $pseudo, $email, $password)
    {
        $db = $this->dbConnect();
         if (not_empty(['name', 'pseudo', 'email', 'password', 'password_confirm'])) {
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
        }
        if (is_already_in_use('email', $email, 'users')) {
            $errors[] = "Adresse email déjà utilisée";
        }
        if (count($errors) == 0) {
            //send email activation
            $to = $email;
            $subject = WEBSITE_NAME. " - ACTIVATION DE COMPTE";
            $password = sha1($password);
            $token = sha1($pseudo.$email.$password);

            ob_start();
            require('views/templates/emails/activation.tmpl.php');
            $content = ob_get_clean();
            //everything will be settled in temporary memory but not not display

            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

            mail($to, $subject, $content, $headers);

            //inform user to check mailbox
            set_flash("Mail d'activation envoyé", "danger");

            $q = $db->prepare('INSERT INTO users (name, pseudo, email, password) 
VALUES (:name, :pseudo, :email, :password)');
            $datauser = $q ->execute([
                'name' => $name,
                'pseudo' => $pseudo,
                'email' => $email,
                'password' => $password

            ]);
            redirect('../index.php');
            exit();
        } else {
            save_input_data(); //save datas but need a function to recover them
        }
    } else {
        $errors[] = "Veuillez remplir tous les champs";
        save_input_data();
    }
} 

    public function loginUser($identifiant, $password){
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
}