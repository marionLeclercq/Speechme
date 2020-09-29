<?php
session_start();
include "include/connexion_BdD.php";
include "include/_langue.php";
    
    $sql = "SELECT * FROM themes WHERE langage = '$langue'"; 
    $themes = $pdo->query($sql)->fetchAll(); 
   
    // array contient les langues qui vont correspondre au préfixe
	$array = [];
	foreach ( $themes as $key => $value )
	{
        // teste si le préfixe et la langue correspondent (par exemple 'fr' correspond avec 'français')
		if ( preg_match( "/^" . strtolower(trim($_GET["prefix"])) . "/", strtolower(trim($value['theme'])) ) ) {
			array_push($array,['theme'=> $value['theme'], 'id'=> $value['id']]);
		}
			
	}
	// on envoie le résultat (une liste de noms de langues) au format JSON
	echo json_encode($array);
	
?>