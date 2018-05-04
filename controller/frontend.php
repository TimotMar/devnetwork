<?php
/*
*This file is used for loading the classes only
*These classes are used for the post managing system
*
**/
// classes loading
require_once('model/PostManager.php');
require_once('model/CommentManager.php');

//all functions management
function listPosts()
{
    $postManager = new \Devnetwork\Blog\Model\PostManager();
    $posts = $postManager->getPosts();

    require('views/listPostsView.php');
}

function post()
{
    $postManager = new \Devnetwork\Blog\Model\PostManager();
    $commentManager = new \Devnetwork\Blog\Model\CommentManager();

    $post = $postManager->getPost($_GET['id']);
    $comments = $commentManager->getComments($_GET['id']);

    require('views/postView.php');
}

function modifier()
{
    $postManager = new \Devnetwork\Blog\Model\PostManager();

    $post = $postManager->getPost($_GET['id']);

    require('views/modifier.php');
}

function delete()
{
    $postManager = new \Devnetwork\Blog\Model\PostManager();
    $posts = $postManager->getPosts();

    require('views/listPostsView.php');
}



function addComment($postId, $author, $comment)
{
    $commentManager = new \Devnetwork\Blog\Model\CommentManager();

    $affectedLines = $commentManager->postComment($postId, $author, $comment);

    if ($affectedLines === false) {
        throw new Exception('Impossible d\'ajouter le commentaire !');
    }
    else {
        header('Location: index.post.php?action=post&id=' . $postId);
    }
}

function addPost($title, $content, $pseudonyme)
{
    $postManager = new \Devnetwork\Blog\Model\PostManager();

    $affectedPosts = $postManager->postPost($title, $content, $pseudonyme);

    if ($affectedPosts === false) {
        throw new Exception('Impossible d\'ajouter l\'article !');
    }
    else {
        header('Location: index.post.php');
    }
}

function changePost($id, $title, $content, $pseudonyme)
{
    $postManager = new \Devnetwork\Blog\Model\PostManager();

    $affectedPosts = $postManager->modifierPost($id, $title, $content, $pseudonyme);

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
