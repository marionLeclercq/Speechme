<?php
include "include/connexion_BdD.php";

    
    $sql = "SELECT * FROM villes"; 
    $villes = $pdo->query($sql)->fetchAll(); 
   
    // array contient les villes qui vont correspondre au préfixe
	$array = [];
	foreach ( $villes as $key => $value )
	{
        // teste si le préfixe et la ville correspondent (par exemple 'Ni' correspond avec 'Nice')
		if ( preg_match( "/^" . strtolower(trim($_GET["prefix"])) . "/", strtolower(trim($value['ville_nom_reel'])) ) ) {
			array_push($array,['nom_ville'=> $value['ville_nom_reel'], 'id'=> $value['id']]);
		}
			
	}
	// on envoie le résultat (une liste de noms de villes) au format JSON
	echo json_encode($array);
	
?>
