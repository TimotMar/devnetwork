<?php
/*
*This file regroups all the functions used on the website
*
*
**/

if (!function_exists('e')) {
    function e($string)
    {
        if ($string) {
            return htmlspecialchars($string);
        }
    }
}

//redirection to asked page
if (!function_exists('redirect_intent_or')) {
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
}


if (!function_exists('get_session')) {
    function get_session($key)
    {
        if ($key) {
            return !empty($_SESSION[$key]) ? e($_SESSION[$key]) : null;
// ternary : return !empty($_SESSION['input'][$key]) ? $_SESSION['input'][$key] : null;
        }
    }
}
//recovering of local language
if (!function_exists('get_current_local')) {
    function get_current_local()
    {
        return $_SESSION['local'];
    }
}

//check if user is logged
if (!function_exists('is_logged_in()')) {
    function is_logged_in()
    {
        return isset($_SESSION['user_id']) || isset($_SESSION['pseudo']); //booleen : true or false. if one of them good : true
    }
}

//get_avatar_url
if (!function_exists('get_avatar_url')) {
    function get_avatar_url($email, $size = 25)
    {
        return "http://fr.gravatar.com/avatar/".md5(strtolower(e(trim($email))))."?s=".$size;//trim used to delete spaces
    }
}


    //find_user_by_id
if (!function_exists('find_user_by_id')) {
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
}

if (!function_exists('not_empty')) { //defined : existance of a constant, not of a function
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
}

if (!function_exists('is_already_in_use')) {
    function is_already_in_use($field, $value, $table)
    {
        $db = new PDO('mysql:host=localhost;dbname=boom', 'root', 'TimPucelle:92');
        $q = $db->prepare("SELECT id FROM $table WHERE $field = ?"); // l
        $q->execute([$value]);

        $count = $q->rowCount();
        $q->closeCursor();
        return $count; //0 if value exists ; so false, 1 if exists so true
    }
}

if (!function_exists('set_flash')) {
    function set_flash($message, $type = 'info')
    {

        $_SESSION['notification']['message'] = $message;
        $_SESSION['notification']['type'] = $type;
    }
}
if (!function_exists('redirect')) {
    function redirect($page)
    {

        header('Location: '.$page);
        exit();
    }
}

if (!function_exists('save_input_data')) { // save firsts written datas
    function save_input_data()
    {
        foreach ($_POST as $key => $value) {//key : name, password... and value : field value
 //save datas in an array
            if (strpos($key, 'password') === false) {//in key : find password. if false : value not found
                $_SESSION['input'][$key] = $value;
            }
        }
    }
}

if (!function_exists('get_input')) { // save firsts written datas
    function get_input($key)
    {
        if (!empty($_SESSION['input'][$key])) {
            return e($_SESSION['input'][$key]);
        } else {
            return null;
        }
// ternary : return !empty($_SESSION['input'][$key]) ? $_SESSION['input'][$key] : null;
    }
}

if (!function_exists('clear_input_data')) { // save firsts written datas
    function clear_input_data()
    {
        if (isset($_SESSION['input'])) {
            $_SESSION['input'] = [];
        }
    }
}
// active state of our differents links
