<?php
/*
*This file is used for the mail sending system to the contact form
*
*
**/
if (isset($_POST['envoi'])) {
    $to = "tim.marissal@gmail.com"; // this is your Email address
    $from = $_POST['mail']; // this is the sender's Email address
    $nom = $_POST['nom'];
    $subject = "Formulaire de contact";
    $message = $nom . " a ecrit:" . "\n\n" . $_POST['message'];

    $headers = "De:" . $from;
    mail($to, $subject, $message, $headers);
    echo "Mail envoye. ";
    // You can also use header('Location: thank_you.php'); to redirect to another page.
}
