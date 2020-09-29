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
    $deco = $phrase[48];
    $deco_confirm= $phrase[50];
    $sure= $phrase[52];
    $oops= $phrase[54];
    $yes= $phrase[56];
    $m= $phrase[8];
    $p= $phrase[10];
}
else{
    $espace= $phrase[31];
    $profil= $phrase[33];
    $rechercher= $phrase[35];
    $creer= $phrase[37];
    $deco = $phrase[49];
    $deco_confirm= $phrase[51];
    $sure= $phrase[53];
    $oops= $phrase[55];
    $yes= $phrase[57];
    $m= $phrase[9];
    $p= $phrase[11];
}

/***** Deconnexion *****/
if (isset($_POST['deconnexion'])) { 
    unset($_SESSION['email']);
    unset($_SESSION['prenom']);
    unset($_SESSION['photo']);
    unset($_SESSION['role']);
    header("Location: index.php");
}  

$role = $_SESSION['role'];

/***** RENDER TWIG *****/
echo $twig->render('deconnexion.html.twig', 
    	  array(
            'langue'=>$langue,
            'page'=> 'deconnexion',
            'profil'=>$profil,
            'rechercher'=>$rechercher,
            'creer'=>$creer,
            'deco'=>$deco,
            'espace'=>$espace,
            'deco_confirm'=>$deco_confirm,
            'sure'=>$sure,
            'oops'=>$oops,
            'yes'=>$yes,
            'role'=>$role,
            'm'=>$m,
            'p'=>$p
            ));
?>