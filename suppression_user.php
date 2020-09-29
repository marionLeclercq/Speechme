<?php
session_start();
require "include/init_twig.php";
include "include/connexion_BdD.php";
include "include/_langue.php";
include "include/classes/authentif.php";

/***** Instanciation *****/
$login = new login('user');

/***** Vérification de l'authentification de l'utilisateur ******/
$login->checkLogin('user');

/***** Traduction des textes *****/
$traductions = file("Ressources/traductions.csv", FILE_IGNORE_NEW_LINES);
$phrase = explode(',', implode(",", $traductions));
if($langue =="fr"){
    $espace = $phrase[30];
    $profil= $phrase[32];
    $rechercher= $phrase[34];
    $creer= $phrase[36];
    $confirm = $phrase[142];
    $oops= $phrase[54];
    $yes= $phrase[56];
    $delete=$phrase[92];
    $m= $phrase[8];
    $p= $phrase[10];
}
else{
    $espace= $phrase[31];
    $profil= $phrase[33];
    $rechercher= $phrase[35];
    $creer= $phrase[37];
    $confirm = $phrase[143];
    $oops= $phrase[55];
    $yes= $phrase[57];
    $delete=$phrase[93];
    $m= $phrase[9];
    $p= $phrase[11];
}

/**Suppression user */
if(isset($_POST['suppression'])){
   $login->suppression_user($_SESSION['id']);
   header('Location:index.php');
}


/***** Render TWIG *****/
echo $twig->render('suppression_user.html.twig', 
    	  array(
            'langue'=>$langue,
            'page'=> 'suppression_user',
            'profil'=>$profil,
            'rechercher'=>$rechercher,
            'creer'=>$creer,
            'espace'=>$espace,
            'confirm'=>$confirm,
            'oops'=>$oops,
            'yes'=>$yes,
            'delete'=>$delete,
            'm'=>$m,
            'p'=>$p


));
?>