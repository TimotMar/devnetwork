<?php
/*
*This file is used for loading the classes only
*These classes are used for the post managing system
*
**/
// classes loading
require_once('model/PostManager.php');
require_once('model/CommentManager.php');
require_once('model/UserManager.php');

//all functions management
function addComment($postId, $author, $comment, $post_mail, $post_pseudo)
{
    $commentManager = new \Devnetwork\Blog\Model\CommentManager();

    $affectedLines = $commentManager->postComment($postId, $author, $comment, $post_mail, $post_pseudo);

    if ($affectedLines === false) {
        throw new Exception('Impossible d\'ajouter le commentaire !');
    } else {
        ?><script><?php echo("Location: index.post.php?action=post&id=' . $postId");?></script><?php
    }
}

function listPosts()
{
    $postManager = new \Devnetwork\Blog\Model\PostManager();
    $posts = $postManager->getPosts();

    require('views/listposts.view.php');
}

function accueil()
{
    $userManager = new \Devnetwork\Blog\Model\UserManager();
    require('views/index.view.php');
}

function liste()
{
    $userManager = new \Devnetwork\Blog\Model\UserManager();
    $users = $userManager->getListe();

    require('views/list_users.view.php');
}

function inscription()
{
    $userManager = new \Devnetwork\Blog\Model\UserManager();

    require('views/register.view.php');
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

function logintheUser()
{
    $userManager = new \Devnetwork\Blog\Model\UserManager();
    $userHasBeenFound = $userManager->loginUser($_POST['identifiant'], $_POST['password']);

    require('views/login.view.php');
}

function login()
{
    $userManager = new \Devnetwork\Blog\Model\UserManager();

    require('views/login.view.php');
}

function post()
{
    $postManager = new \Devnetwork\Blog\Model\PostManager();
    $commentManager = new \Devnetwork\Blog\Model\CommentManager();

    $post = $postManager->getPost($_GET['id']);
    $comments = $commentManager->getComments($_GET['id']);

    require('views/post.view.php');
}

function profile()
{
    $userManager = new \Devnetwork\Blog\Model\UserManager();
    $profile = $userManager->getProfile($_GET['id']);

    require('views/profile.view.php');
}

function modifier()
{
    $postManager = new \Devnetwork\Blog\Model\PostManager();

    $post = $postManager->getPost($_GET['id']);

    require('views/modifier.view.php');
}

function delete()
{
    $postManager = new \Devnetwork\Blog\Model\PostManager();
    $posts = $postManager->getPosts();

    require('views/listposts.view.php');
}

function change()
{
    $userManager = new \Devnetwork\Blog\Model\UserManager();

    $profile = $userManager->getProfile($_GET['id']);

    require('views/edit_user.view.php');
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
