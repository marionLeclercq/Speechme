<?php
require "include/init_twig.php";
include "include/connexion_BdD.php";

/***** Changement de langue *****/
$langue = 'fr';
if(isset($_SESSION['langue']))
    $langue = $_SESSION['langue']; 

if(isset($_GET['langue'])) {
    switch($_GET['langue']) {
        case 'fr':
        case 'en':
            $langue = $_GET['langue'];
    }
}
$_SESSION['langue'] = $langue;