<?php
session_start();
include "../include/connexion_BdD.php";

//Suppression de l'évenement
$stmt1 = $pdo->prepare("DELETE FROM `evenement` WHERE `id`=?");
$stmt1->execute([ $_POST['id'] ]);

//Validation = "oui"
$stmt2 = $pdo->prepare("UPDATE `evenement` SET validation='oui' WHERE `id`=?");
$stmt2->execute([ $_POST['id1'] ]);

//Stockage du message d'alerte de suppression de l'événement à tous les participants
$stmt3 = $pdo->prepare("INSERT IGNORE INTO messages (message, id_user1, prenom_user1, id_user2, nom_event,status) VALUES (?,?,?,?,?,?) ");
$stmt3->execute([$_POST['message'], $_POST['id_user1'],$_POST['prenom_user1'], $_POST['id_user2'],$_POST['nom_event'], "nonlu"]);
