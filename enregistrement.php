<?php
session_start();
require "include/init_twig.php";
include "include/connexion_BdD.php";
include "include/_langue.php";
include "include/functions.php";
include "include/classes/authentif.php";

/***** Instanciation *****/
$login = new login('user');

$register = isset($_POST['register']);
$badSignUp = $login->badSignUp();
$badSignUpMsg = $login->badSignUpMsg();

if($register){
    $conditions= isset($_POST['conditions']);
    $login->doSignUp(valid_donnees($_POST['username']),valid_donnees($_POST['email']),valid_donnees($_POST["password"]), valid_donnees($_POST["password2"]),valid_donnees($_POST["id_ville"]), $conditions);
   
}

/***** Traduction des textes *****/
$traductions = file("Ressources/traductions.csv", FILE_IGNORE_NEW_LINES);
$phrase = explode(',', implode(",", $traductions));
if($langue =="fr"){
    $home = $phrase[12];
    $e= $phrase[4];
    $prenom= $phrase[22];
    $ville= $phrase[24];
    $email= $phrase[14];
    $pwd1= $phrase[26];
    $pwd2= $phrase[28];
    $send= $phrase[20];
    $acc=$phrase[160];
    $m= $phrase[8];
    $p= $phrase[10];
}
else{
    $home= $phrase[13];
    $e= $phrase[5];
    $prenom= $phrase[23];
    $ville= $phrase[25];
    $email= $phrase[15];
    $pwd1= $phrase[27];
    $pwd2= $phrase[29];
    $send= $phrase[21];
    $acc=$phrase[161];
    $m= $phrase[9];
    $p= $phrase[11];
}

/***** Render TWIG *****/
echo $twig->render('enregistrement.html.twig', 
    	  array(
            'langue'=>$langue,
            'register' => $register,
            'badSignUp'=> $badSignUp,
            'badSignUpMsg' => $badSignUpMsg,
            'page'=> "enregistrement",
            'e'=>$e,
            'home'=>$home,
            'prenom'=>$prenom,
            'ville'=>$ville,
            'email'=>$email,
            'pwd1'=>$pwd1,
            'pwd2'=>$pwd2,
            'send'=>$send,
            'acc'=>$acc,
            'm'=>$m,
            'p'=>$p
          
            ));

