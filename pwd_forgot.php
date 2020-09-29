<?php
session_start();
require "include/init_twig.php";
include "include/connexion_BdD.php";
include "include/_langue.php";
include "include/classes/authentif.php";

$login = new login('user');
$envoyer = isset($_POST['envoyer']);
$badSignIn = $login->badSignIn();
$badSignInMsg = $login->badSignInMsg();


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

/***** Mot de passe oublié ******/

$isset_error = isset($error);
$section= "";
$recup_mail="";
if(isset($_GET['section'])) {
    switch($_GET['section']) {
        case 'code':
        case 'changemdp':
            $section = $_GET['section'];
    }
    $recup_mail= $_SESSION['recup_mail'];
}
$error="";


if(isset($_POST['recup_submit'],$_POST['recup_mail'])) {
   if(!empty($_POST['recup_mail'])) {
      $recup_mail = htmlspecialchars($_POST['recup_mail']);
      if(filter_var($recup_mail,FILTER_VALIDATE_EMAIL)) {
        $mailexist = $pdo->prepare('SELECT id,prenom FROM user WHERE email = ?');
        $mailexist->execute(array($recup_mail));
        $mailexist_count = $mailexist->rowCount();
        if($mailexist_count == 1) {
            $pseudo = $mailexist->fetch();
            $pseudo = $pseudo['prenom'];
            $_SESSION['recup_mail'] = $recup_mail;
            $recup_code = "";
            for($i=0; $i < 8; ++$i) {
               $recup_code .= mt_rand(0,9);
            }
            $mail_recup_exist = $pdo->prepare('SELECT id FROM recuperation WHERE email = ?');
            $mail_recup_exist->execute(array($recup_mail));
            $mail_recup_exist = $mail_recup_exist->rowCount();
            if($mail_recup_exist == 1) {
               $recup_insert = $pdo->prepare('UPDATE recuperation SET code = ? WHERE email = ?');
               $recup_insert->execute(array($recup_code,$recup_mail));
            } else {
               $recup_insert = $pdo->prepare('INSERT INTO recuperation(email,code) VALUES (?, ?)');
               $recup_insert->execute(array($recup_mail,$recup_code));
            }
            $header="MIME-Version: 1.0\r\n";
            $header.='From:"[VOUS]"<hete06@gmail.com>'."\n";
            $header.='Content-Type:text/html; charset="utf-8"'."\n";
            $header.='Content-Transfer-Encoding: 8bit';
            $message = '<html>
                            <head>
                             <title>Récupération de mot de passe - Votresite</title>
                             <meta charset="utf-8" />
                            </head>
                            <body>
                             <font color="#303030";>
                                 <div align="center">
                                <table width="600px">
                                     <tr>
                                     <td>
                                        <div align="center">Bonjour <b>'.$pseudo.'</b>,</div>
                                        Voici votre code de récupération: <b>'.$recup_code.'</b>
                                        A bientôt sur <a href="#">Votre site</a> !
                                     </td>
                                     </tr>
                                     <tr>
                                     <td align="center">
                                        <font size="2">
                                         Ceci est un email automatique, merci de ne pas y répondre
                                        </font>
                                     </td>
                                     </tr>
                                </table>
                                 </div>
                             </font>
                            </body>
                        </html>';
            mail($recup_mail, "Récupération de mot de passe - Votresite", $message, $header);
            header("Location: pwd_forgot.php?section=code");
        } else {
            $error = "Cette adresse mail n'est pas enregistrée";
        }
      } else {
         $error = "Adresse mail invalide";
      }
   } else {
      $error = "Veuillez entrer votre adresse mail";
   }
}
if(isset($_POST['verif_submit'],$_POST['verif_code'])) {
   if(!empty($_POST['verif_code'])) {
      $verif_code = htmlspecialchars($_POST['verif_code']);
      $verif_req = $pdo->prepare('SELECT id FROM recuperation WHERE email = ? AND code = ?');
      $verif_req->execute(array($_SESSION['recup_mail'],$verif_code));
      $verif_req = $verif_req->rowCount();
      if($verif_req == 1) {
         $up_req = $pdo->prepare('UPDATE recuperation SET confirme = 1 WHERE email = ?');
         $up_req->execute(array($_SESSION['recup_mail']));
         header('Location: pwd_forgot.php?section=changemdp');
      } else {
         $error = "Code invalide";
      }
   } else {
      $error = "Veuillez entrer votre code de confirmation";
   }
}
if(isset($_POST['change_submit'])) {
   if(isset($_POST['change_mdp'],$_POST['change_mdpc'])) {
      $verif_confirme = $pdo->prepare('SELECT confirme FROM recuperation WHERE email = ?');
      $verif_confirme->execute(array($_SESSION['recup_mail']));
      $verif_confirme = $verif_confirme->fetch();
      $verif_confirme = $verif_confirme['confirme'];
      if($verif_confirme == 1) {
         $mdp = htmlspecialchars($_POST['change_mdp']);
         $mdpc = htmlspecialchars($_POST['change_mdpc']);
         if(!empty($mdp) AND !empty($mdpc)) {
            if($mdp == $mdpc) {
               $mdp = password_hash($mdp,PASSWORD_DEFAULT);;
               $ins_mdp = $pdo->prepare('UPDATE user SET password = ? WHERE email = ?');
               $ins_mdp->execute(array($mdp,$_SESSION['recup_mail']));
               $del_req = $pdo->prepare('DELETE FROM recuperation WHERE email = ?');
               $del_req->execute(array($_SESSION['recup_mail']));
               header('Location: connexion.php?badsignin=2');
            } else {
               $error = "Vos mots de passe ne correspondent pas";
            }
         } else {
            $error = "Veuillez remplir tous les champs";
         }
      } else {
         $error = "Veuillez valider votre mail grâce au code de vérification qui vous a été envoyé par mail";
      }
   } else {
      $error = "Veuillez remplir tous les champs";
   }
}

/***** Render Twig *****/
echo $twig->render('pwd_forgot.html.twig', 
    	  array(
                'langue'=>$langue,
                'page'=> "pwd_forgot",
                'envoyer' => $envoyer,
                'badSignIn'=> $badSignIn,
                'badSignInMsg' => $badSignInMsg,
                'c'=>$c,
                'home'=>$home,
                'email'=>$email,
                'pwd'=>$pwd,
                'pwd_forgot'=>$pwd_forgot,
                'send'=>$send,
                'section'=>$section,
                'error'=>$error,
                'isset_error'=>$isset_error,
                'recup_mail'=>$recup_mail,
                'm'=>$m,
                'p'=>$p
            ));
         
?>