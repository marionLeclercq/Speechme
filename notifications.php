<?php
session_start();
require "include/init_twig.php";
include "include/connexion_BdD.php";
include "include/_langue.php";
include "include/classes/authentif.php";
include "include/classes/evenements.php";

/***** Instanciation  *****/
$login = new login('user');
$login->checkLogin('user');
$event = new Event('evenement');

/***** Traduction des textes *****/
$traductions = file("Ressources/traductions.csv", FILE_IGNORE_NEW_LINES);
$phrase = explode(',', implode(",", $traductions));
if($langue =="fr"){
    $send= $phrase[20];
    $espace = $phrase[30];
    $profil= $phrase[32];
    $rechercher= $phrase[34];
    $creer= $phrase[36];
   
    $m= $phrase[8];
    $p= $phrase[10];
}
else{
    $send= $phrase[21];
    $espace= $phrase[31];
    $profil= $phrase[33];
    $rechercher= $phrase[35];
    $creer= $phrase[37];
   
    $m= $phrase[9];
    $p= $phrase[11];
}

/** Recupération des messages de l'utilisateur (id_user2 dans la table `messages`) */
$id_user=$_SESSION['id'];
$infos_msg= $pdo->query("SELECT*FROM `messages` WHERE JSON_CONTAINS(`id_user2`, '$id_user') ORDER BY ID DESC")->fetchAll();

$infos_msg_empty= empty($infos_msg);

//Changement du status des messages de nonlu en lu
$pdo->prepare("UPDATE messages SET status = 'lu' WHERE JSON_CONTAINS(`id_user2`, '$id_user')")->execute();


/***** Render TWIG*****/
echo $twig->render('notifications.html.twig', 
    	  array(
            'langue'=>$langue,
            'page'=>"notifications",
            'profil'=>$profil,
            'espace'=>$espace,
            'rechercher'=>$rechercher,
            'creer'=>$creer,
            'infos_msg'=>$infos_msg,
            'infos_msg_empty'=>$infos_msg_empty,
            'm'=>$m,
            'p'=>$p
            ));
?>
            