<?php
session_start();
require "include/init_twig.php";
include "include/connexion_BdD.php";
include "include/classes/authentif.php";
include "include/classes/evenements.php";
include "include/_langue.php";

/***** Instanciation *****/
$login = new login('user');
$event = new Event('evenement');

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
    $descriptif=$phrase[62];
    $participants=$phrase[64];
    $debut=$phrase[94];
    $fin=$phrase[96];
    $participer=$phrase[98];
    $organisateur=$phrase[100];
    $annuler=$phrase[116];
    $annuler_part=$phrase[118];
    $alert_suppression=$phrase[168];
    $y=$phrase[120];
    $m= $phrase[8];
    $p= $phrase[10];
}
else{
    $espace= $phrase[31];
    $profil= $phrase[33];
    $rechercher= $phrase[35];
    $creer= $phrase[37];
    $descriptif=$phrase[63];
    $participants=$phrase[65];
    $debut=$phrase[95];
    $fin=$phrase[97];
    $participer=$phrase[99];
    $organisateur=$phrase[101];
    $annuler=$phrase[117];
    $annuler_part=$phrase[119];
    $alert_suppression=$phrase[169];
    $y=$phrase[121];
    $m= $phrase[9];
    $p= $phrase[11];
}


/** Récupération de l'id de l'événement et de ses différentes informations */

if(isset($_SESSION['id_event']))
    $id_event = $_SESSION['id_event']; 
if(isset($_GET['id_event'])) 
    $id_event = $_GET['id_event'];
$_SESSION['id_event'] = $id_event;

	
$infos= $event->infos_event('id',$id_event);

$infos_src = json_decode($infos['photo'],true);

$nom = $infos['nom'];
$description= $infos['description'];
$dateEN= $infos['date'];
setlocale(LC_TIME, "fr_FR");
$date = strftime("%A %d %B %G", strtotime($dateEN));
$heuredeb= $infos['heure'];
$heure1=strftime("%H:%M", strtotime($heuredeb));
$heurefin= $infos['heure_fin'];
$heure2=strftime("%H:%M", strtotime($heurefin));
$adresse= $infos['adresse_lieu'];
$nom_ville = $event->nom_ville($infos['id_villes']);
$ville= $nom_ville['ville_nom_reel'];
$prenom_organisateur= $event->prenom_organisateur($infos['id_user']);
$prenom= $prenom_organisateur['prenom'];

/** Récupération de l'id de l'organisateur et comparaison avec l'id du membre connecté*/
$id_user=$infos['id_user'];
$id_user_session=$_SESSION['id'];

/** Vérification si le membre participe déjà à cet événement */
$participation = $event->verif_participation($id_user_session,$id_event);

/**Récupération id participants et des photos de profil */
$tab_id_part=$event->id_participant($id_event);
$tab_infos=[];
$array=[];
foreach($tab_id_part as $key){
    array_push($array, $key['id_user']);
    $infos=$login->infos($key['id_user']);
    array_push($tab_infos, $infos);
}

$json_id_participants = json_encode($array);

/***** Render TWIG *****/
echo $twig->render('descriptif.html.twig', 
    	  array(
            'langue'=>$langue,
            'id_event'=>$id_event,
            'page'=>"descriptif",
            'profil'=>$profil,
            'espace'=>$espace,
            'rechercher'=>$rechercher,
            'creer'=>$creer,
            'descriptif'=>$descriptif,
            'participants'=>$participants,
            'organisateur'=>$organisateur,
            'infos_src'=>$infos_src,
            'nom'=>$nom,
            'description'=>$description,
            'date'=>$date,
            'heure1'=>$heure1,
            'heure2'=>$heure2,
            'adresse'=>$adresse,
            'ville'=>$ville,
            'prenom'=>$prenom,
            'id_user'=>$id_user,
            'id_user_session'=>$id_user_session,
            'tab_infos'=>$tab_infos,
            'annuler_part'=>$annuler_part,
            'annuler'=>$annuler,
            'participation'=>$participation,
            'y'=>$y,
            'debut'=>$debut,
            'fin'=>$fin,
            'participer'=>$participer,
            'alert_suppression'=>$alert_suppression,
            'json_id_participants'=>$json_id_participants,
            'm'=>$m,
            'p'=>$p
            ));
?>