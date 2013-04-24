<?php

require_once 'connexion.php';
// Si pas de variable GET on redirige vers l'index.
//
if ( !isset( $_GET['mail'] ) ) header('Location: ../../index.php');

// On prépare le mail
//
$message = "Merci de bien venir rendre votre livre que vous avez loué à la bibliothèque! Merci.";
$recipient = $_GET['mail'];
$subject = "Rappel de la bibliothèque";
$mailheaders = "Reply-to: n.widart@gmail.com";

//On envoie le mail
//
mail($recipient, $subject, $message, $mailheaders);
header('Location: ../../index.php');
