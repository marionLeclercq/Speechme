<?php
session_start();
require "include/init_twig.php";
include "include/connexion_BdD.php";
include "include/_langue.php";
include "include/classes/authentif.php";
include "include/classes/evenements.php";

/***** Instanciation  *****/
$login = new login('user');
$event = new Event('evenement');

/***** Vérification de l'authentification de l'utilisateur *****/
$login->checkLogin('user');

/***** Traduction des textes *****/
$traductions = file("Ressources/traductions.csv", FILE_IGNORE_NEW_LINES);
$phrase = explode(',', implode(",", $traductions));
if($langue =="fr"){
    $send= $phrase[20];
    $espace = $phrase[30];
    $profil= $phrase[32];
    $rechercher= $phrase[34];
    $creer= $phrase[36];
    $msg=$phrase[102];
    $le=$phrase[104];
    $mes=$phrase[106];
    $j=$phrase[108];
    $speak=$phrase[110];
    $learn=$phrase[112];
    $retour=$phrase[166];
    $m= $phrase[8];
    $p= $phrase[10];
}
else{
    $send= $phrase[21];
    $espace= $phrase[31];
    $profil= $phrase[33];
    $rechercher= $phrase[35];
    $creer= $phrase[37];
    $mes=$phrase[107];
    $msg=$phrase[103];
    $le=$phrase[105];
    $j=$phrase[109];
    $speak=$phrase[111];
    $learn=$phrase[113];
    $retour=$phrase[167];
    $m= $phrase[9];
    $p= $phrase[11];
}

/***** Récupération des informations du membre *****/

if(isset($_SESSION['id_user']))
    $id_user = $_SESSION['id_user']; 
if(isset($_GET['id'])) 
    $id_user = $_GET['id'];
$_SESSION['id_user'] = $id_user;

$infos = $login ->infos($id_user);
$photo = $infos['photo'];
$prenom = $infos['prenom'];
$villes = $login->display_ville($id_user);
$ville = $villes['ville_nom_reel'];
$description = $infos['description'];

    /**-- Langues parlées --*/
    $tab_id_langues_parlees= $login->speaklang($id_user);
    $array_nom_langue_parlee = [];
    foreach($tab_id_langues_parlees as $key){
        $tab_nom_langue= $pdo ->query("SELECT nom_langue FROM `langue` WHERE id = '{$key["id_langues_parlees"]}'")->fetchAll();
        foreach($tab_nom_langue as $key){
            $nom_langue = $key['nom_langue'];
            array_push($array_nom_langue_parlee, $nom_langue);
        }
    }
        /** Langues en apprentissage */
    $tab_id_langues_apprentissage= $login->learnlang($id_user);
    $array_nom_langue_apprentissage = [];
    foreach($tab_id_langues_apprentissage as $key){
            $tab_nom_langue= $pdo ->query("SELECT nom_langue FROM `langue` WHERE id = '{$key["id_langues_apprentissage"]}'")->fetchAll();
            foreach($tab_nom_langue as $key){
                $nom_langue = $key['nom_langue'];
                array_push($array_nom_langue_apprentissage, $nom_langue);
            }
    }

$infos_events = $event -> infos_events('id_user', $id_user);

/** Envoi d'un message */
$submit=isset($_POST['submitMsg']);
if($submit){
    $message= $_POST["msg"];
    $id_user_receive=$id_user;
    $id_user_send=$_SESSION["id"];
    $array_prenom= $pdo->query("SELECT `prenom` FROM `user` WHERE id = '$id_user_send'")->fetch();
    $prenom_user_send=$array_prenom['prenom'];
    $msg_send = $pdo ->prepare("INSERT INTO `messages` (`message`,`id_user1`,`prenom_user1`,`id_user2`, nom_event,status) VALUES (?,?,?,?,?,?)");
    $msg_send->execute([$message, $id_user_send, $prenom_user_send, $id_user_receive, "", "nonlu"]);
}


/***** Render *****/
echo $twig->render('affichage_profil.html.twig', 
    	  array(
            'langue'=>$langue,
            'page'=>"affichage_profil",
            'profil'=>$profil,
            'espace'=>$espace,
            'rechercher'=>$rechercher,
            'creer'=>$creer,
            'prenom'=>$prenom,
            'ville'=>$ville,
            'photo'=>$photo,
            'array_nom_langue_parlee'=>$array_nom_langue_parlee,
            'array_nom_langue_apprentissage'=>$array_nom_langue_apprentissage,
            'infos_events'=>$infos_events,            
            'description'=>$description,
            'msg'=>$msg,
            'le'=>$le,
            'mes'=>$mes,
            'j'=>$j,
            'learn'=>$learn,
            'speak'=>$speak,
            'submit'=>$submit,
            'send'=>$send,
            'retour'=>$retour,
            'm'=>$m,
            'p'=>$p

            ));
?>
            