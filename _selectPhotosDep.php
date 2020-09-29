<?php
session_start();
include "include/connexion_BdD.php";

$infos_photos=$pdo->query("SELECT id, photo1 FROM `evenement` WHERE departement = '{$_GET["dep"]}' AND validation = 'oui' AND `date` >= DATE(NOW()) ORDER BY RAND() LIMIT 4")->fetchAll(); 


$array = [];
foreach ( $infos_photos as $key  )
{
    array_push($array,['photo1'=> $key['photo1'], 'id'=> $key['id']]);    
}

echo json_encode($array);

