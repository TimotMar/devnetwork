<?php
/*
*This file is the index of the post system
*
*
**/
session_start();
include('controller/includes/constants.php');
require("controller/includes/functions.php");
require("views/index.post.view.php");
require('controller/frontend.php');
//index of the post functionnality
//includes of all the exceptions of the post system


try {
    if (isset($_GET['action'])) {
        if ($_GET['action'] == 'listPosts') {
            listPosts();
        } elseif ($_GET['action'] == 'post') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                post();
            } else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        } elseif ($_GET['action'] == 'addComment') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                if (!empty($_POST['author']) && !empty($_POST['comment'])) {
                    addComment($_GET['id'], $_POST['author'], $_POST['comment']);
                } else {
                    throw new Exception('Tous les champs ne sont pas remplis !');
                }
            } else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        } elseif ($_GET['action'] == 'addPost') {
            if (!empty($_POST['title']) && !empty($_POST['content']) && !empty($_POST['pseudonyme'])) {
                    addPost($_POST['title'], $_POST['content'], $_POST['pseudonyme']);
            } else {
                    throw new Exception('Tous les champs ne sont pas remplis !');
            }
        } elseif ($_GET['action'] == 'modifier') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                modifier();
            } else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        } elseif ($_GET['action'] == 'changePost') {
            if (!empty($_POST['title']) && !empty($_POST['content']) && !empty($_POST['pseudonyme'])) {
                    changePost($_GET['id'], $_POST['title'], $_POST['content'], $_POST['pseudonyme']);
            } else {
                    throw new Exception('Tous les champs ne sont pas remplis !');
            }
        } elseif ($_GET['action'] == 'deletePost') {
                deletePost($_GET['id']);
        }
    } else {
        listPosts();
    }
} catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}
