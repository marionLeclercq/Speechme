<?php
session_start();
require "include/init_twig.php";
include "include/connexion_BdD.php";
include "include/_langue.php";
include "include/functions.php";
include "include/classes/authentif.php";

/***** Instanciation *****/
$login = new login('user');

$envoyer = isset($_POST['envoyer']);
$badSignIn = $login->badSignIn();
$badSignInMsg = $login->badSignInMsg();

if($envoyer){
    $login->doSignIn($_POST["email"],$_POST["password"]);   
}

/***** Traduction des textes *****/
$traductions = file("Ressources/traductions.csv", FILE_IGNORE_NEW_LINES);
$phrase = explode(',', implode(",", $traductions));
if($langue =="fr"){
    $home = $phrase[12];
    $c= $phrase[2];
    $email= $phrase[14];
    $pwd= $phrase[16];
    $pwd_forgot= $phrase[18];
    $send= $phrase[20];
    $m= $phrase[8];
    $p= $phrase[10];
}
else{
    $home= $phrase[13];
    $c= $phrase[3];
    $email= $phrase[15];
    $pwd= $phrase[17];
    $pwd_forgot= $phrase[19];
    $send= $phrase[21];
    $m= $phrase[9];
    $p= $phrase[11];
}

/***** Render Twig *****/
echo $twig->render('connexion.html.twig', 
    	  array(
                'langue'=>$langue,
                'page'=> "connexion",
                'envoyer' => $envoyer,
                'badSignIn'=> $badSignIn,
                'badSignInMsg' => $badSignInMsg,
                'c'=>$c,
                'home'=>$home,
                'email'=>$email,
                'pwd'=>$pwd,
                'pwd_forgot'=>$pwd_forgot,
                'send'=>$send,
                'm'=>$m,
                'p'=>$p
            ));
         
?>