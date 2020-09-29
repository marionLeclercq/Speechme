<?php
session_start();
include "include/connexion_BdD.php";

//Récupération du nombre de ligne dans la table `messages`
$id_user=$_SESSION['id'];
$tab_row = $pdo->query("SELECT COUNT(*) FROM `messages` WHERE JSON_CONTAINS(`id_user2`, '$id_user') AND status = 'nonlu'")->fetch();
echo $tab_row['COUNT(*)'];

