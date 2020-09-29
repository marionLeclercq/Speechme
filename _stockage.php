<?php
session_start();
include "include/connexion_BdD.php";

//Stockage du message d'alerte de suppression de l'événement à tous les participants
$stmt4 = $pdo->prepare("INSERT IGNORE INTO messages (message, id_user1, prenom_user1, id_user2, nom_event,status) VALUES (?,?,?,?,?,?) ");
$stmt4->execute([$_POST['message'], $_POST['id_user1'],$_POST['prenom_user1'], $_POST['id_user2'],$_POST['nom_event'], "nonlu"]);