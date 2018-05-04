<?php
/*
*This file is used for loading the pages only allowed to guest
*
*
**/

if (isset($_SESSION['user_id']) && isset($_SESSION['pseudo'])) {
    header('Location: ../../index.php'); // redirection
    exit();
}
