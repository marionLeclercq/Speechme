<?php
session_start();
include "../include/connexion_BdD.php";
include "../include/classes/authentif.php";

$login = new login('user');
$login->checkLogin('admin');


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
                <a href="index_BO"><img src="../images/logo.png" alt="logo"></a>
            </div>  
        </header>   
        <main>  
            <section id="users_BO">
                <h1>Les membres du site</h1>
                <a href="index_BO.php">&larr; Retour page accueil</a>
<?php 
$informations = $pdo -> query("SELECT id,prenom,email,description,photo FROM user WHERE role='user'")->fetchAll();
?>
                <table>
                    <tr>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Description</th>
                        <th>Photo</th>
                        <th>Actions</th>
                    </tr>
<?php
foreach($informations as $information):
   
?>
                    <tr class="tr" data-id = "<?php echo $information['id']; ?>">
                        <td data-label="Prénom"><?php echo $information['prenom']; ?></td>
                        <td data-label="Email"><?php echo $information['email']; ?></td>
                        <td data-label="Description"><p><?php echo $information['description']; ?></p></td>
                        <td data-label="Photo"><img src="<?php echo "../".$information['photo']; ?>"></td>
                        <td data-label="Actions"><button type="submit" name="sup_membre" class="sup_membre" data-id = "<?php echo $information['id']; ?>">Supprimer le membre</button><button type="submit" name="sup_photo" class="sup_photo" data-id = "<?php echo $information['id']; ?>">Supprimer photo</button><button type="submit" name="sup_descr" class="sup_descr" data-id = "<?php echo $information['id']; ?>">Supprimer description</button></td>
                    <tr>
<?php                
endforeach;
?>
                </table>
            </section>
        </main>
    </div>

<!-- ******  SCRIPT JS ****** -->
<script src= "../JS/confirmation_delete.js"></script>
<script src= "../JS/menu_responsive.js"></script> 
</body>
</html>