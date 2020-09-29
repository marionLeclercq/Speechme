<?php
session_start();
require "include/init_twig.php";
include "include/connexion_BdD.php";
include "include/_langue.php";
include "include/classes/evenements.php";

/***** Instanciation *****/
$event = new Event('evenement');

/***** Traduction des textes *****/
$traductions = file("Ressources/traductions.csv", FILE_IGNORE_NEW_LINES);
$phrase = explode(',', implode(",", $traductions));
if($langue =="fr"){
    $h1 = $phrase[0];
    $c= $phrase[2];
    $e= $phrase[4];
    $h2= $phrase[6];
    $sel=$phrase[144];
    $m= $phrase[8];
    $p= $phrase[10];
}
else{
    $h1 = $phrase[1];
    $c= $phrase[3];
    $e= $phrase[5];
    $h2= $phrase[7];
    $sel=$phrase[145];
    $m= $phrase[9];
    $p= $phrase[11];
}

/**** Récupération des codes postaux ****/
$departements=$pdo->query("SELECT DISTINCT ville_departement FROM villes")->fetchAll();

/** Récupération des photos, alt et id des événements situés dans le département selectionné par défaut */
$num_departement= '06';
$photos = $event ->photo($num_departement);
/***** Render Twig *****/
echo $twig->render('index.html.twig', 
    	  array(
                'langue'=>$langue,
                'page'=> "index",
                'h1'=> $h1,
                'c'=>$c,
                'e'=>$e,
                'h2'=>$h2,
                'departements'=>$departements,
                'num_departement'=>$num_departement,
                'photos'=>$photos,
                'sel'=>$sel,
                'm'=>$m,
                'p'=>$p
            ));

?>
            