<?php
session_start();
include "include/connexion_BdD.php";

//Ajout du participant dans la table `participants`
$stmt1 = $pdo->prepare("INSERT IGNORE INTO participants (id_user,id_evenement) VALUES (?,?) ");
$stmt1->execute([$_POST['idUser'], $_POST['idEvent']]);

//Suppression de l'association de l'événement et de l'utilisateur, dans la table `participants`
$stmt2 = $pdo->prepare("DELETE FROM `participants` WHERE `id_user`=? AND id_evenement=?");
$stmt2->execute([ $_POST['idUser2'], $_POST['idEvent2']]);

//Suppression événement
$sup_row= $pdo ->prepare("DELETE FROM  `participants` WHERE id_evenement=?"); 
$sup_row->execute([ $_POST['idEvent3']]);
$stmt3 = $pdo->prepare("DELETE FROM `evenement` WHERE id=?");
$stmt3->execute([ $_POST['idEvent3']]);

//Suppression notification
$sup_notif= $pdo ->prepare("DELETE FROM messages WHERE id= ?");
$sup_notif->execute([$_POST['idMsg']]);




