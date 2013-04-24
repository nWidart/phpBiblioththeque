<?php
require_once 'connexion.php';
// Si pas de variable GET on redirige vers l'index.
//
if ( !isset( $_GET['id'] ) ) header('Location: ../../index.php');

// On récupère la variable GET
//
$id = $_GET['id'];

// On DELETE
try {
    $sql = "DELETE FROM emprunts WHERE id=$id";
    $count = $db->exec( $sql );
    // echo "<script>document.location.href = 'index.php';</script>";
    header('Location: ../../index.php');
} catch( Exception $e ) {
    echo "Erreur:".$e->getMessage();
}
