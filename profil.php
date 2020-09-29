<?php
session_start();
require "include/init_twig.php";
include "include/connexion_BdD.php";
include "include/_langue.php";
include "include/functions.php";
include "include/classes/authentif.php";

/***** Instanciation *****/
$login = new login('user');

/***** Vérification de l'authentification de l'utilisateur ******/
$login->checkLogin('user');

/***** Traduction des textes *****/
$traductions = file("Ressources/traductions.csv", FILE_IGNORE_NEW_LINES);
$phrase = explode(',', implode(",", $traductions));
if($langue =="fr"){
    $pm= $phrase[22];
    $v= $phrase[24];
    $espace = $phrase[30];
    $profil= $phrase[32];
    $rechercher= $phrase[34];
    $creer= $phrase[36];
    $modif=$phrase[66];
    $ajout=$phrase[68];
    $afficher=$phrase[70];
    $d=$phrase[74];
    $mf=$phrase[72];
    $choix=$phrase[76];
    $choix2=$phrase[78];
    $speak=$phrase[80];
    $learn=$phrase[82];
    $valider=$phrase[84];
    $changepwd=$phrase[86];
    $new=$phrase[88];
    $new2=$phrase[90];
    $delete=$phrase[92];
    $m= $phrase[8];
    $p= $phrase[10];
}
else{
    $pm= $phrase[23];
    $v= $phrase[25];
    $espace= $phrase[31];
    $profil= $phrase[33];
    $rechercher= $phrase[35];
    $creer= $phrase[37];
    $modif=$phrase[67];
    $ajout=$phrase[69];
    $afficher=$phrase[71];
    $mf=$phrase[75];
    $d=$phrase[73];
    $choix=$phrase[77];
    $choix2=$phrase[79];
    $speak=$phrase[81];
    $learn=$phrase[83];
    $valider=$phrase[85];
    $changepwd=$phrase[87];
    $new=$phrase[89];
    $new2=$phrase[91];
    $delete=$phrase[93];
    $m= $phrase[9];
    $p= $phrase[11];
}

/***** Téléchargement et modification de la photo de profil *****/

$echec= "";
$email= $_SESSION['email'];
$photo_tab = $login->photo($email);
$photo = $photo_tab['photo'];

if(isset($_POST['afficher'])) {
    if(move_uploaded_file($_FILES['userfile']['tmp_name'], 'upload/'.$_FILES['userfile']['name'])) {
        $_SESSION['photo'] = "upload/".$_FILES['userfile']['name']."";
        $photo = $_SESSION['photo'];
        $login->addPhoto($photo, $email);
    } 
    else $echec = "Echec de l'envoi, réessayez";
}

/***** Modifications des informations de profil *****/

    /** Récupérations des données enregistrées de l'utilisateur */
$user = $login->user();
$nom_ville = $login ->affichage_ville($email);
$ville = $nom_ville['ville_nom_reel'];
$id_ville = $login ->affichage_id_ville($email);
$desc = $login -> affichage_descr($email);
$description = $desc['description'];
$id_user= $_SESSION['id'];

        /**-- Langues parlées --*/
$tab_id_langues_parlees= $login->langues_parlees($email);
$array_nom_langue_parlee = [];
$array_id_langue_parlee = [];
$i=0;
foreach($tab_id_langues_parlees as $key){
    $tab_nom_langue= $pdo ->query("SELECT nom_langue FROM `langue` WHERE id = '{$key["id_langues_parlees"]}'")->fetchAll();
    array_push($array_id_langue_parlee, $key["id_langues_parlees"]);
    foreach($tab_nom_langue as $key){
        $nom_langue = $key['nom_langue'];
        array_push($array_nom_langue_parlee, $nom_langue);
     }
}
        /** Langues en apprentissage */
$tab_id_langues_apprentissage= $login->langues_apprentissage($email);
$array_nom_langue_apprentissage = [];
$array_id_langue_apprentissage = [];
$j=0;
foreach($tab_id_langues_apprentissage as $key){
        $tab_nom_langue= $pdo ->query("SELECT nom_langue FROM `langue` WHERE id = '{$key["id_langues_apprentissage"]}'")->fetchAll();
        array_push($array_id_langue_apprentissage, $key["id_langues_apprentissage"]);
        foreach($tab_nom_langue as $key){
            $nom_langue = $key['nom_langue'];
            array_push($array_nom_langue_apprentissage, $nom_langue);
        }
}

/***** Mise à jour des infos lors de l'envoi du formulaire *****/
if(isset($_POST['modif_profil'])){
        /** Prénom */
    $prenom = valid_donnees($_POST['username']);
    $login->modifications($email, 'prenom',$prenom);
    $get_user = $login -> getName($email);
    $user = $get_user['prenom'];
    $_SESSION['prenom'] = $user;
        /** Ville */
    $id_ville = valid_donnees($_POST['id_ville']);
    $login->modifications($email,'id_villes',$id_ville);
    $get_ville = $login -> affichage_ville($email);
    $ville = $get_ville['ville_nom_reel'];
        /** Description */
    $desc = valid_donnees($_POST['description']);
    $login->modifications($email,'description',$desc);
    $get_desc = $login -> affichage_descr($email);
    $description = $get_desc['description'];
        /** Langues parlées */
        if(isset($_POST['id_speakLang'])){
            foreach($_POST['id_speakLang'] as $key_id => $id_langue_parlee){
                $login->insert_id($email, $id_langue_parlee);
                $tab_id_langues_parlees= $login->langues_parlees($email);
                $array_nom_langue_parlee = [];
                $array_id_langue_parlee = [];
                foreach($tab_id_langues_parlees as $key){
                    $tab_nom_langue= $pdo ->query("SELECT nom_langue FROM `langue` WHERE id = '{$key["id_langues_parlees"]}'")->fetchAll();
                    array_push($array_id_langue_parlee, $key["id_langues_parlees"]);
                    foreach($tab_nom_langue as $key){
                        $nom_langue = $key['nom_langue'];
                        array_push($array_nom_langue_parlee, $nom_langue);
                        }
                }
            }
        }
        /** Langues en apprentissage */
        if(isset($_POST['id_learnLang'])){
            foreach($_POST['id_learnLang'] as $key_id => $id_langue_apprentissage){
                $login->insert_id_learn($email, $id_langue_apprentissage);
                $tab_id_langues_apprentissage= $login->langues_apprentissage($email);
                $array_nom_langue_apprentissage = [];
                $array_id_langue_apprentissage = [];
                foreach($tab_id_langues_apprentissage as $key){
                        $tab_nom_langue= $pdo ->query("SELECT nom_langue FROM `langue` WHERE id = '{$key["id_langues_apprentissage"]}'")->fetchAll();
                        array_push($array_id_langue_apprentissage, $key["id_langues_apprentissage"]);
                        foreach($tab_nom_langue as $key){
                            $nom_langue = $key['nom_langue'];
                            array_push($array_nom_langue_apprentissage, $nom_langue);
                        }
                }
            }
        }
}

/***** Modification du mot de passe *****/
$badSignIn = $login->badSignUp();
$badSignInMsg = $login->badSignUpMsg();

if(isset($_POST['modif_pwd'])){
    $login-> verif_pwd($email,$_POST["password"],$_POST["password2"]);
}


/***** Render Twig *****/
echo $twig->render('profil.html.twig', 
    	  array(
            'langue'=>$langue,
            'page'=>"profil",
            'profil'=>$profil,
            'espace'=>$espace,
            'user' => $user,
            'modif'=>$modif,
            'ajout'=>$ajout,
            'afficher'=>$afficher,
            'mf'=>$mf,
            'pm'=>$pm,
            'v'=>$v,
            'd'=>$d,
            'choix'=>$choix,
            'choix2'=>$choix2,
            'speak' =>$speak,
            'learn'=>$learn,
            'valider'=>$valider,
            'changepwd'=>$changepwd,
            'new'=>$new,
            'new2'=>$new2,
            'ville'=>$ville,
            'delete'=>$delete,
            'id_ville'=>$id_ville,
            'array_nom_langue_parlee'=>$array_nom_langue_parlee,
            'array_id_langue_parlee'=>$array_id_langue_parlee,
            'array_nom_langue_apprentissage'=>$array_nom_langue_apprentissage,
            'array_id_langue_apprentissage'=>$array_id_langue_apprentissage,
            'i'=>$i,
            'badSignUp'=> $badSignIn,
            'badSignUpMsg' => $badSignInMsg,
            'description'=> $description,
            'rechercher'=>$rechercher,
            'creer'=>$creer,
            'photo'=>$photo,
            'echec'=>$echec,
            'id_user'=>$id_user,
            'm'=>$m,
            'p'=>$p
            ));
?>