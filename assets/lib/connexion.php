<?php
$hostname = 'localhost';
$username = 'root';
$password = 'root';

try{
    $db = new PDO( "mysql:host=$hostname;dbname=ajphp", $username, $password );
    $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
}catch( PDOException $e ) {
    echo 'Erreur: '.$e->getMessage();
}
