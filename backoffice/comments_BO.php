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
                <a href="index_BO.php"><img src="../images/logo.png" alt="logo"></a>
            </div>  
        </header>   
        <main>  
            <section id="comments_BO">
                <a href="index_BO.php">&larr; Retour page accueil</a>


            </section>
        </main>
    </div>

<!-- ******  SCRIPT JS ****** -->
<script src= "../JS/confirmation_delete.js"></script>
<script src= "../JS/menu_responsive.js"></script> 
</body>
</html>