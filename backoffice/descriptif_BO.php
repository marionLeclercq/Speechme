<?php
session_start();
include "../include/connexion_BdD.php";
include "../include/classes/authentif.php";

$login = new login('user');
$login->checkLogin('admin');
$id_event=$_POST['id_event'];
$infos = $pdo -> query("SELECT * FROM evenement WHERE id = '$id_event'")->fetch();
$infos_ville = $pdo->query("SELECT ville_nom_reel FROM `villes` WHERE id='{$infos["id_villes"]}'")->fetch();
$infos_user = $pdo ->query("SELECT * FROM `user` WHERE id='{$infos["id_user"]}'")->fetch();
setlocale(LC_TIME, "fr_FR");
?>

<!DOCTYPE html>
<html lang='fr'>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>SpeechMe - Page administrateur</title>
    <!-- ******  CSS ****** -->
    <link rel="stylesheet" media="all" href="../CSS/normalize.css">
    <link rel="stylesheet" media="all" href="../CSS/style.css">
    <!-- ******  FONT ****** -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro&display=swap" rel="stylesheet">
    <!-- ******  JQUERY ****** -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
   
</head>

<body>
    <div class="container">
        <header class="pusher">
                <nav>    
                    <a href="events_BO.php">Les évenements</a>
                    <a href="users_BO.php">Les membres</a>
                    <a href="comments_BO.php">Les commentaires</a>
                </nav>
                <a href="" id = "header_icone" class="header_icone"></a>
            <div id="logo">
                <a href="index_BO.php"><img src="../images/logo.png" alt="logo"></a>
            </div>  
        </header>   
        <main>  
            <section id ="descriptif_BO">
                <h1><?php echo $infos['nom']; ?></h1>
                <a href="events_BO.php">&larr; Retour page évènements</a>
                <div id="photos">

<?php $photos = json_decode($infos['photo'],true);
foreach ($photos as $photo): ?>
                    <img src="<?php echo "../".$photo; ?>"  alt="<?php echo "Photos event"; ?>" >
<?php endforeach; ?>
                </div>
                <p><?php echo $infos['description']; ?></p>
                <div id="infos">
                    <div>
                        <img src="../images/calendar.svg" alt="logo_agenda" width="20">
                        <span><?php echo strftime("%A %d %B %G", strtotime($infos['date'])); ?></span><br>
                        <span>début: <?php echo strftime("%H:%M", strtotime($infos['heure'])); ?></span>
                        <span>/ fin: <?php echo strftime("%H:%M", strtotime($infos['heure_fin'])); ?></span>
                    </div>
                    <div>
                        <img src="../images/position.svg" alt="logo_position" width="20">
                        <span><?php echo $infos['adresse_lieu']; ?>,</span>
                        <span><?php echo $infos_ville['ville_nom_reel']; ?></span>
                    </div>
                    <div>
                        <img src="../images/personne.svg" alt="logo_membre" width="20">
                        <span id='organisateur' data-id='<?php echo $infos_user['id']; ?>'><?php echo $infos_user['prenom'];?></span>
                        <span><?php echo '/ '.$infos_user['email']; ?></span>
                    </div>
                </div>
                <div>
<?php 
    if($infos['validation']=='non'):
?>
                    <button type="submit" name="valider" id="valider" data-id="<?php echo $id_event;?>">Valider</button>
                    <input type="hidden" name="alert" id="alert_valid"  value="Votre évènement a été validé: <?php echo $infos['nom']; ?>.">
<?php
    endif;
?>
                    <button type="submit" name="supprimer" id='supprimer' data-id="<?php echo $id_event;?>" >Supprimer</button>
                    <input type="hidden" name="alert" id="alert_sup"  value="Votre évènement n'a pas été validé: <?php echo $infos['nom']; ?>.">
                </div>
            </section>
        </main>
    </div>

<!-- ******  SCRIPT JS ****** -->
<script src= "../JS/actionsEvents_BO.js"></script>
<script src= "../JS/menu_responsive.js"></script> 
</body>
</html>