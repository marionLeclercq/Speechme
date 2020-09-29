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
    $connexion=$phrase[2];
    $profil= $phrase[32];
    $rechercher= $phrase[34];
    $creer= $phrase[36];
    $user= $phrase[60];
    $e= $phrase[4];
    $m= $phrase[8];
    $p= $phrase[10];
}
else{
    $ml= $phrase[59];
    $accueil=$phrase[13];
    $connexion=$phrase[3];
    $profil= $phrase[33];
    $rechercher= $phrase[35];
    $creer= $phrase[37];
    $user= $phrase[61];
    $e= $phrase[5];
    $m= $phrase[9];
    $p= $phrase[11];
}



echo $twig->render('sitemap.html.twig', 
    	  array(
            'langue'=>$langue,
            'page'=> 'sitemap',
            'ml'=>$ml,
            'profil'=>$profil,
            'rechercher'=>$rechercher,
            'creer'=>$creer,
            'user'=>$user,
            'accueil'=>$accueil,
            'connexion'=>$connexion,
            'e'=>$e,
            'm'=>$m,
            'p'=>$p

            ));
?>