<?php
session_start();
require "include/init_twig.php";
include "include/connexion_BdD.php";
include "include/_langue.php";
include "include/classes/authentif.php";

/***** Traduction des textes *****/
$traductions = file("Ressources/traductions.csv", FILE_IGNORE_NEW_LINES);
$phrase = explode(',', implode(",", $traductions));
if($langue =="fr"){
    $espace = $phrase[30];
    $profil= $phrase[32];
    $rechercher= $phrase[34];
    $creer= $phrase[36];
    
    $m= $phrase[8];
    $p= $phrase[10];
}
else{
    $espace= $phrase[31];
    $profil= $phrase[33];
    $rechercher= $phrase[35];
    $creer= $phrase[37];
    
    $m= $phrase[9];
    $p= $phrase[11];
}

/***** Render Twig *****/
echo $twig->render('404.html.twig', 
    	  array(
            'm'=>$m,
            'p'=>$p

        ));
        ?>