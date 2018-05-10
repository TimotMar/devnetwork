<?php
/*
*This file regroups all the functions used on the website
*
*
**/
require_once('model/PostManager.php');
require_once('model/CommentManager.php');
require_once('model/UserManager.php');

//protection of written datas
function e($string)
{
    if ($string) {
        return htmlspecialchars($string);
    }
}

//redirection to asked page
function redirect_intent_or($default_url)
{
    if ($_SESSION['forwarding_url']) {
        $url = $_SESSION['forwarding_url'];//redirection to asked page
    } else {
        $url = $default_url;
    }
    $_SESSION['forwarding_url'] = null;//avoid loop redirection
    redirect($url);
}

//recover of datas stocked into the $_SESSION variable
function get_session($key)
{
    if ($key) {
        return !empty($_SESSION[$key]) ? e($_SESSION[$key]) : null;
// ternary : return !empty($_SESSION['input'][$key]) ? $_SESSION['input'][$key] : null;
    }
}

//recovering of local language
function get_current_local()
{
    return $_SESSION['local'];
}

//check if user is logged
function is_logged_in()
{
    return isset($_SESSION['user_id']) || isset($_SESSION['pseudo']); //booleen : true or false. if one of them good : true
}

//get_avatar_url : recover of the avatar stocked in an external website called gravatar
function get_avatar_url($email, $size = 25)
{
    return "http://fr.gravatar.com/avatar/".md5(strtolower(e(trim($email))))."?s=".$size;//trim used to delete spaces
}


//find_user_by_id : recover the user using the id data
function find_user_by_id($id)
{
    global $db;

    $q = $db->prepare('SELECT name, pseudo, email, city, country, twitter, github, 
facebook, sex, available_for_hiring, bio FROM users WHERE id=?');
    $q->execute([$id]);

    $data = $q->fetch(PDO::FETCH_OBJ);

    $q->closeCursor();
    return $data;
}

 //defined : existance of a constant, not of a function. Does not allow to submit without fulling the input
function not_empty($fields = [])
{
    if (count($fields) !=0) {
        foreach ($fields as $field) {
            if (empty($_POST [$field]) || trim($_POST[$field]) == "") { //trim escape all spaces. If empty : false
                return false;
            }
        }
        return true ; //fields filled
    }
}



function is_already_in_use($field, $value, $table)
{
    $db = new PDO('mysql:host=localhost;dbname=boom', 'root', 'TimPucelle:92');
    $q = $db->prepare("SELECT id FROM $table WHERE $field = ?"); // l
    $q->execute([$value]);

    $count = $q->rowCount();
    $q->closeCursor();
    return $count; //0 if value exists ; so false, 1 if exists so true
}


function set_flash($message, $type = 'info')
{

    $_SESSION['notification']['message'] = $message;
    $_SESSION['notification']['type'] = $type;
}

function redirect($page)
{
    header('Location: '.$page);
    exit();
}
// save firsts written datas
function save_input_data()
{
    foreach ($_POST as $key => $value) {//key : name, password... and value : field value
 //save datas in an array
        if (strpos($key, 'password') === false) {//in key : find password. if false : value not found
            $_SESSION['input'][$key] = $value;
        }
    }
}
// get firsts written datas
function get_input($key)
{
    if (!empty($_SESSION['input'][$key])) {
        return e($_SESSION['input'][$key]);
    } else {
        return null;
    }
// ternary : return !empty($_SESSION['input'][$key]) ? $_SESSION['input'][$key] : null;
}
// clear firsts written datas
function clear_input_data()
{
    if (isset($_SESSION['input'])) {
        $_SESSION['input'] = [];
    }
}

function addComment($postId, $author, $comment, $post_mail, $post_pseudo)
{
    $commentManager = new \Devnetwork\Blog\Model\CommentManager();

    $affectedLines = $commentManager->postComment($postId, $author, $comment, $post_mail, $post_pseudo);

    if ($affectedLines === false) {
        throw new Exception('Impossible d\'ajouter le commentaire !');
    } else {
     echo '<script language="Javascript"> document.location.replace("index.post.php?action=post&id=' . $postId .'"); </script>';
    }
}

function register($name, $pseudo, $email, $password, $password_confirm, $country, $city)
{
    $userManager = new \Devnetwork\Blog\Model\UserManager();
    $datauser = $userManager->registerUser($_POST['name'], $_POST['pseudo'], $_POST['email'], $_POST['password'], $_POST['password_confirm'], $_POST['country'], $_POST['city']);

    if ($datauser === false) {
        throw new Exception('Impossible de vous inscrire !');
    } else {
        header('Location: index.php');
    }
}

function activation()
{
    $userManager = new \Devnetwork\Blog\Model\UserManager();
    $q = $userManager->activationUser($_GET['p'], $_GET['token']);

    if ($q === false) {
        throw new Exception('Impossible d\'activer le compte !');
    } else {
        header('Location: index.php?action=login');
    }
}

function addPost($title, $content, $chapo, $pseudo, $post_mail)
{
    $postManager = new \Devnetwork\Blog\Model\PostManager();

    $affectedPosts = $postManager->postPost($title, $content, $chapo, $pseudo, $post_mail);

    if ($affectedPosts === false) {
        throw new Exception('Impossible d\'ajouter l\'article !');
    } else {
        header('Location: index.post.php');
    }
}

function changePost($id, $title, $content, $chapo, $pseudo)
{
    $postManager = new \Devnetwork\Blog\Model\PostManager();

    $affectedPosts = $postManager->modifierPost($id, $title, $content, $chapo, $pseudo);

    if ($affectedPosts === false) {
        throw new Exception('Impossible de changer l\'article !');
    } else {
        header('Location: index.post.php?action=modifier&id=' . $id);
    }
}

function deletePost($id)
{
    $postManager = new \Devnetwork\Blog\Model\PostManager();

    $affectedPosts = $postManager->deletePost($id);

    if ($affectedPosts === false) {
        throw new Exception('Impossible de supprimer l\'article !');
    } else {
        header('Location: index.post.php');
    }
}

function changeUser($id, $name, $city, $country, $sex, $twitter, $github, $facebook, $available_for_hiring, $bio)
{
    $userManager = new \Devnetwork\Blog\Model\UserManager();

    $affectedUser = $userManager->modifierUser($id, $name, $city, $country, $sex, $twitter, $github, $facebook, $available_for_hiring, $bio);//présent dans le Usermanager

    if ($affectedUser === false) {
        throw new Exception('Impossible de changer le user !');
    } else {
        header('Location: index.php?action=profile&id=' . $id);
    }
}

function deleteComment($id)
{
    $commentManager = new \Devnetwork\Blog\Model\CommentManager();

    $affectedComments = $commentManager->deleteComment($id);

    if ($affectedComments === false) {
        throw new Exception('Impossible de supprimer le commentaire !');
    } else {
        header('Location: index.post.php');
    }
}

function validateComment($id)
{
    $commentManager = new \Devnetwork\Blog\Model\CommentManager();

    $affectedComments = $commentManager->validateComment($id);

    if ($affectedComments === false) {
        throw new Exception('Impossible de valider le commentaire !');
    } else {
        header('Location: index.post.php');
    }
}
