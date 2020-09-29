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
    $ml= $phrase[58];
    $accueil=$phrase[12];
    $m= $phrase[8];
    $p= $phrase[10];
}
else{
    $ml= $phrase[59];
    $accueil=$phrase[13];
    $m= $phrase[9];
    $p= $phrase[11];
}


echo $twig->render('CGU.html.twig', 
    	  array(
            'langue'=>$langue,
            'page'=> 'mentions',
            'ml'=>$ml,
            'accueil'=>$accueil,
            'm'=>$m,
            'p'=>$p
            ));
?>