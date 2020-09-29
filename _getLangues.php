<?php
session_start();
include "include/connexion_BdD.php";
include "include/_langue.php";

//Suppression langue parlée
$stmt1 = $pdo->prepare("DELETE FROM `assoc_user_langues_parlees` WHERE id_user=? AND id_langues_parlees=?");
$stmt1->execute([$_POST['idUser'], $_POST['idSpeak']]);

//Suppression langue en apprentissage
$stmt2 = $pdo->prepare("DELETE FROM `assoc_user_langues_apprentissage` WHERE id_user=? AND id_langues_apprentissage=?");
$stmt2->execute([$_POST['idUser'], $_POST['idLearn']]);