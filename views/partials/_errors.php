<?php
/*
*This file is used for adding errors to the differents pages
*
*
**/
if (isset($errors) && count($errors) != 0) {//if errors exist
    echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&time</button>';
    foreach ($errors as $error) {
        echo $error.'<br/>';
    }
    echo '</div';
}
