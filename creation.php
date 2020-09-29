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
$event = new Event('evenement');

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
    $afficher=$phrase[70];
    $nom_event=$phrase[146];
    $select=$phrase[148];
    $other=$phrase[150];
    $lp=$phrase[152];
    $address=$phrase[154];
    $time=$phrase[156];
    $add=$phrase[158];
    $champs=$phrase[136];
    $afficher=$phrase[70];
    $valider=$phrase[84];
    $v=$phrase[124];
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
    $afficher=$phrase[71];
    $nom_event=$phrase[147];
    $select=$phrase[149];
    $other=$phrase[151];
    $lp=$phrase[153];
    $address=$phrase[155];
    $time=$phrase[157];
    $add=$phrase[159];
    $champs=$phrase[137];
    $afficher=$phrase[71];
    $valider=$phrase[85];
    $v=$phrase[125];
    $m= $phrase[9];
    $p= $phrase[11];
}
/***** Affichage des photos de l'événement *****/
$echec= "";
$array_photos=[];
$array_photos_encode=NULL;
$photo1=[];
$affichage = isset($_POST['afficher']);
$error=false;
$msg="";
$nom="";
$themes="";
$description="";
$ville="";
$adresse="";
$date="";
$debut="";
$fin =""; 

if($affichage) {
    foreach($_FILES as $file) { 
        if($file['error']== UPLOAD_ERR_NO_FILE){
            continue;
        }
        if(move_uploaded_file($file['tmp_name'], 'upload/'.$file['name'])) {
            array_push($array_photos, 'upload/'.$file['name']);
        } 
        else $echec = "Echec de l'envoi, réessayez";
        $photo1=$array_photos[0];
    } 
$array_photos_encode = json_encode($array_photos);

}


/***** Ajout de l'événement dans la table `evenement` */
if(isset($_POST['valider'])){
    $nom= $_POST['nom'];
    $adresse=$_POST['adresse'];
    $dateFR=$_POST['date'];
    $date = strftime("%Y-%m-%d", strtotime($dateFR));
    $debut=$_POST['debut'];
    $fin=$_POST['fin'];
    $ville=$_POST['ville'];
    $id_ville=$_POST['id_ville'];
    $array_departement = $pdo->query("SELECT ville_departement FROM villes WHERE id = '$id_ville'")->fetch();
    $departement = $array_departement['ville_departement'];
    $themes=$_POST['themes'];
    $id_themes = json_encode($_POST['id_themes']);
    $id_user = $_SESSION['id'];
    $description=$_POST['description'];
    
    if(empty($_POST['photos'])){
        $error=true;
        $msg= "Veuillez télécharger au moins une photo";
    }
    elseif(empty($_POST['id_speakLang']) ){
        $error=true;
        $msg="Veuillez sélectionnez et ajouter les langues pratiquées";
    }
    elseif(empty($_POST['id_themes'])){
        $error=true;
        $msg="Sélectionnez le thème de votre évènement";
    }
    elseif(empty($_POST['id_ville'])){
        $error=true;
        $msg="Sélectionnez la ville de votre évènement";
    }
    else{
        
        $event->add_event($nom, $description, $adresse, $date, $debut, $fin, $_POST['photos'][0], $_POST['photo_principale'], $id_ville, $departement, $id_themes, json_encode( $_POST['id_speakLang'] ), $id_user);
        $error = true;
        $msg = "Votre évènement a bien été enregistré, il doit être soumis à validation avant sa mise en ligne, vous en serez averti par message.";
    }
  
}
   
/***** Render Twig *****/
echo $twig->render('creation.html.twig', 
    	  array(
            'langue'=>$langue,
            'page'=>"creation",
            'profil'=>$profil,
            'espace'=>$espace,
            'afficher'=>$afficher,
            'valider'=>$valider,
            'rechercher'=>$rechercher,
            'creer'=>$creer,
            'nom_event'=>$nom_event,
            'select'=>$select,
            'other'=>$other,
            'lp'=>$lp,
            'address'=>$address,
            'time'=>$time,
            'add'=>$add,
            'v'=>$v,
            'champs'=>$champs,
            'affichage'=>$affichage,
            'photo1'=>$photo1,
            'array_photos_encode'=>$array_photos_encode,
            'array_photos'=>$array_photos,
            'error'=>$error,
            'msg'=>$msg,
            'm'=>$m,
            'p'=>$p,
            'nom'=>$nom,
            'theme'=>$themes,
            'description'=>$description,
            'ville'=>$ville,
            'adresse'=>$adresse,
            'date'=>$date,
            'debut'=>$debut,
            'fin'=>$fin    
           
          
            ));

?>