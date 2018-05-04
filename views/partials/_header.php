<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Blog pour tous ! ">
    <meta name="author" content="Timothee Marissal">

    <title>
        <?php //constants website name
        echo isset($title)
        ? $title.' - ' . WEBSITE_NAME
        : WEBSITE_NAME .'- Un blog pour tous :';
        ?>
    </title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/readable/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../public/assets/js/google-code-prettify/prettify.css"/>
    <link rel="stylesheet" href="../../public/assets/css/main.css"/>
    <!-- Custom styles for this template -->
<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=ej2wev80ezbidzkh7q4d9ddl28v4ctqoc6zvmuww82zrroi6"></script> 
</head>
<body>

<?php include('_menu.php'); ?>
<?php include('_flash.php'); ?>