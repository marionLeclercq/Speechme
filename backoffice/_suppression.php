<?php
session_start();
include "../include/connexion_BdD.php";

/***** Pour membre supprimé ****/

    //Suppression du membre dans la table user
    $stmt = $pdo->prepare("DELETE FROM `user` WHERE `id`=?");
    $stmt->execute([ $_POST['id'] ]);
    //Suppression des évènements créés par le membre qui a été supprimé
    $sup_event= $pdo ->prepare("DELETE FROM `evenement` WHERE `id_user`=?");
    $sup_event->execute([ $_POST['id'] ]);
    //Suppression de la participation du membre à des évènements
    $stmt1 = $pdo->prepare("DELETE FROM `participants` WHERE `id_user`=?");
    $stmt1->execute([ $_POST['id'] ]);
    //Suppression des langues parlées de ce membre
    $stmt2 = $pdo->prepare("DELETE FROM `assoc_user_langues_parlees` WHERE `id_user`=?");
    $stmt2->execute([ $_POST['id'] ]);
    //Suppression des languesen apprentissage de ce membre
    $stmt3 = $pdo->prepare("DELETE FROM `assoc_user_langues_apprentissage` WHERE `id_user`=?");
    $stmt3->execute([ $_POST['id'] ]);
    //Suppression de ses notifications envoyées
    $stmt4 = $pdo->prepare("DELETE FROM `messages` WHERE `id_user1`=? ");
    $stmt4->execute([ $_POST['id'] ]);
    //Suppression de ses notifications recues
    $stmt5 = $pdo->prepare("DELETE FROM `messages` WHERE  `id_user2`=?");
    $stmt5->execute([ $_POST['id'] ]);

/********/

//Suppression photo du membre en remplaçant par un placeholder
$modif_photo = $pdo->prepare("UPDATE `user` SET photo = 'https://via.placeholder.com/50?text=Profil+photo' WHERE `id`=?");
$modif_photo->execute([ $_POST['id1'] ]);

//Suppression description membre
$modif_desc = $pdo->prepare("UPDATE `user` SET description = '' WHERE `id`=?");
$modif_desc->execute([ $_POST['id2'] ]);

?>    