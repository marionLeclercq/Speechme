<?php
session_start();
require "include/init_twig.php";
include "include/connexion_BdD.php";
include "include/_langue.php";
include "include/classes/authentif.php";
include "include/classes/evenements.php";

/***** Instanciation *****/
$login = new login('user');
$event = new Event('evenement');

/***** Vérification de l'authentification de l'utilisateur ******/
$login->checkLogin('user');
$user = $login->user();

/***** Traduction des textes *****/
$traductions = file("Ressources/traductions.csv", FILE_IGNORE_NEW_LINES);
$phrase = explode(',', implode(",", $traductions));
if($langue =="fr"){
    $espace = $phrase[30];
    $profil= $phrase[32];
    $rechercher= $phrase[34];
    $creer= $phrase[36];
    $bonjour= $phrase[38];
    $d= $phrase[40];
    $jp= $phrase[42];
    $jap= $phrase[44];
    $mes=$phrase[46];
    $voir=$phrase[114];
    $cal=$phrase[162];
    $pas=$phrase[164];
    $m= $phrase[8];
    $p= $phrase[10];
}
else{
    $espace= $phrase[31];
    $profil= $phrase[33];
    $rechercher= $phrase[35];
    $creer= $phrase[37];
    $bonjour= $phrase[39];
    $d= $phrase[41];
    $jp= $phrase[43];
    $jap= $phrase[45];
    $mes=$phrase[47];
    $voir=$phrase[115];
    $cal=$phrase[163];
    $pas=$phrase[165];
    $m= $phrase[9];
    $p= $phrase[11];
}

/** Récupération du département de l'utilisateur */
$email= $_SESSION['email'];
$noms_ville = $login ->affichage_ville($email);
$nom_ville = $noms_ville['ville_nom_reel'];
$dep = $login ->code_dep($nom_ville);
$departement = $dep['ville_departement'];

/** Récupération des photos et id des événements situés dans le département de l'utilisateur **/
$photos = $event ->photo($departement);

/** Récupération informations des événements auxquels le membre participe **/
$id_user_session=$_SESSION['id'];
$id_events= $event -> id_events($id_user_session);

$tab_id=[];
foreach($id_events as $key =>$value){
    array_push($tab_id,$value['id_evenement']);
}
$tab_infos=[];
foreach($tab_id as $id_event){
    $infos_events = $pdo->query("SELECT * FROM evenement WHERE id='$id_event' ORDER BY `evenement`.`date` ASC")->fetch();
    array_push($tab_infos,$infos_events);
}
/** Récupérations informations des événements crées par le membre */
$events_crees = $event->infos_events('id_user', $id_user_session);

/***** Render TWIG *****/
echo $twig->render('user.html.twig', 
    	  array(
                'langue'=>$langue,
                'page'=>"user",
                'user' => $user,
                'photos'=>$photos,
                'espace'=>$espace,
                'profil'=>$profil,
                'rechercher'=>$rechercher,
                'creer'=>$creer,
                'bonjour'=>$bonjour,
                'voir'=>$voir,
                'd'=>$d,
                'jp'=>$jp,
                'jap'=>$jap,
                'mes'=>$mes,
                'tab_infos'=>$tab_infos,
                'events_crees'=>$events_crees,
                'pas'=>$pas,
                'cal'=>$cal,
                'm'=>$m,
                'p'=>$p
            ));

?>
            