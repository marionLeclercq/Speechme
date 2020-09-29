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

/***** Traduction des textes *****/
$traductions = file("Ressources/traductions.csv", FILE_IGNORE_NEW_LINES);
$phrase = explode(',', implode(",", $traductions));
if($langue =="fr"){
    $espace = $phrase[30];
    $home = $phrase[12];
    $profil= $phrase[32];
    $rechercher= $phrase[34];
    $creer= $phrase[36];
    $descriptif=$phrase[62];
    $participants=$phrase[64];
    $debut=$phrase[94];
    $fin=$phrase[96];
    $e= $phrase[4];
    $organisateur=$phrase[100];
    $y=$phrase[120];
    $m= $phrase[8];
    $p= $phrase[10];
}
else{
    $espace= $phrase[31];
    $home= $phrase[13];
    $profil= $phrase[33];
    $rechercher= $phrase[35];
    $creer= $phrase[37];
    $descriptif=$phrase[63];
    $participants=$phrase[65];
    $debut=$phrase[95];
    $e= $phrase[5];
    $fin=$phrase[97];
    $organisateur=$phrase[101];
    $y=$phrase[121];
    $m= $phrase[9];
    $p= $phrase[11];
}


/** Récupération de l'id de l'événement et de ses différentes informations */

if(isset($_SESSION['id_event']))
    $id_event = $_SESSION['id_event']; 
if(isset($_POST['id_event'])) 
    $id_event = $_POST['id_event'];
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
$id_user=$infos['id_user'];



/**Récupération id participants et des photos de profil */
$tab_id_part=$event->id_participant($id_event);
$tab_infos=[];
foreach($tab_id_part as $key){
    $infos=$login->infos($key['id_user']);
    array_push($tab_infos, $infos);
}

/***** Render TWIG *****/
echo $twig->render('descriptif_pop.html.twig', 
    	  array(
            'langue'=>$langue,
            'id_event'=>$id_event,
            'page'=>"descriptif_pop",
            'profil'=>$profil,
            'home'=>$home,
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
            'tab_infos'=>$tab_infos,
            'y'=>$y,
            'debut'=>$debut,
            'fin'=>$fin,
            'e'=>$e,
            'm'=>$m,
            'p'=>$p
            ));
?>