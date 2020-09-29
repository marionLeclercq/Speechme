<?php
session_start();
require "include/init_twig.php";
include "include/connexion_BdD.php";
include "include/_langue.php";
include "include/functions.php";
include "include/classes/authentif.php";
include "include/classes/evenements.php";


/***** Instanciation *****/
$login = new login('user');
$login->checkLogin('user');
$user = $login->user();
$event = new Event('evenement');

/***** Traduction des textes *****/
$traductions = file("Ressources/traductions.csv", FILE_IGNORE_NEW_LINES);
$phrase = explode(',', implode(",", $traductions));
if($langue =="fr"){
    $espace = $phrase[30];
    $profil= $phrase[32];
    $rechercher= $phrase[34];
    $creer= $phrase[36];
    $r=$phrase[122];
    $v=$phrase[124];
    $lp=$phrase[126];
    $t=$phrase[128];
    $result=$phrase[130];
    $la=$phrase[132];
    $ex=$phrase[134];
    $champs=$phrase[136];
    $renseig=$phrase[138];
    $depart=$phrase[140];
    $m= $phrase[8];
    $p= $phrase[10];
}
else{
    $espace= $phrase[31];
    $profil= $phrase[33];
    $rechercher= $phrase[35];
    $creer= $phrase[37];
    $r=$phrase[123];
    $v=$phrase[125];
    $lp=$phrase[127];
    $t=$phrase[129];
    $result=$phrase[131];
    $la=$phrase[133];
    $ex=$phrase[135];
    $champs=$phrase[137];
    $renseig=$phrase[139];
    $depart=$phrase[141];
    $m= $phrase[9];
    $p= $phrase[11];
}

/** Récupération des valeurs entrées par l'utilisateur lors de sa recherche */
$recherche_event=NULL;
$research = isset($_POST["rechercher"]);
$error=false;
$msg="";
$dep="";

if($research){
        $id_ville = $_POST['id_ville'];
        $dep = $_POST['departement'];
        $id_speakLang=$_POST['speakLang'];
        $id_learnLang=$_POST['learnLang'];
        $id_theme=$_POST['id_theme'];
        //$dateFR = $_POST['date'];
        //setlocale(LC_TIME, "en_EN");
        //$date = strftime("%Y-%m-%d", strtotime($dateFR)) ;
        if(empty($id_ville)&& empty($dep)){
            $error = true;
            $msg = "Veuillez renseigner une ville (tapez ville et valider avec liste déroulante) ou un département.";
        }
        elseif(empty($id_speakLang)){
            $error = true;
            $msg = "Veuillez renseigner la langue que vous parlez.";
        }
        elseif(empty($id_learnLang)){
            $error = true;
            $msg = "Veuillez renseigner la langue que vous voulez apprendre.";
        }
        else{
            /** Recherche des id événement correspondants à la recherche */
            
            if(strlen($id_theme)!=0){
                $recherche_event=$event->recherche_event2($id_ville, $dep, $id_speakLang, $id_learnLang, $id_theme);
            }
            else{
                $recherche_event=$event->recherche_event1($id_ville, $dep, $id_speakLang, $id_learnLang);
                if($recherche_event==NULL){
                    $error = true;
                    $msg = "Pas encore d'évènements ici...";
                }
            }      
        }      
}
else{
    $error = true;
    $msg = "Pas de recherche effectuée";
}

/***** Render TWIG *****/
echo $twig->render('rechercher.html.twig', 
    	  array(
                'langue'=>$langue,
                'page'=>"rechercher",
                'user' => $user,
                'espace'=>$espace,
                'profil'=>$profil,
                'rechercher'=>$rechercher,
                'creer'=>$creer,
                'v'=>$v,
                'lp'=>$lp,
                'la'=>$la,
                'ex'=>$ex,
                'champs'=>$champs,
                'renseig'=>$renseig,
                'depart'=>$depart,
                't'=>$t,
                'r'=>$r,
                'result'=>$result,
                'recherche_event'=>$recherche_event,
                'research'=>$research,
                'error'=>$error,
                'msg'=>$msg,
                'm'=>$m,
                'dep'=>$dep,
                'p'=>$p
            ));
?>