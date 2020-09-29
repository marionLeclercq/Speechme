<?php
class Event {

    private $table;
    private $pdo;
    
    // '$table' est la table contenant les données
    // des évènements
    public function __construct($table) {
        $this->table = $table;
        $host = 'localhost';
        $db   = 'pt2019-2020_leclercq';
        $user = 'root';
        $pass = '';
        $charset = 'utf8';
    
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            $this->pdo = new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
   

    //Récupération de la photo 1 des évènements localisés dans département de l'utilisateur, de manière aléatoire, maximum 4 et en excluant les évènements passés 
    public function photo($departement){
        return $this->pdo->query("SELECT id, photo1 FROM `{$this->table}` WHERE departement = '$departement' AND validation = 'oui' AND `date` >= DATE(NOW()) ORDER BY RAND() LIMIT 4")->fetchAll();  
    }

    //Récupération des différentes informations de l'événement 
    public function infos_event($colonne, $valeur){
        return $this->pdo->query("SELECT * FROM `{$this->table}` WHERE 
        $colonne = '$valeur'")->fetch();
    }
    //Récupération des différentes informations des événements crées par un utilisateur
    public function infos_events($colonne, $valeur){
        return $this->pdo->query("SELECT * FROM `{$this->table}` WHERE 
        $colonne = '$valeur' ORDER BY `date` ASC")->fetchAll();
    }
    //Récupération du nom de la ville de l'événement
    public function nom_ville($id){
        return $this->pdo->query("SELECT ville_nom_reel FROM `villes` WHERE id='$id'")->fetch();
    }
    //Récupération du prénom de l'organisateur de l'évènement
    public function prenom_organisateur($id){
        return $this->pdo->query("SELECT prenom FROM `user` WHERE id='$id'")->fetch();
    }
   
    //Vérification si le membre participe à l'événement en question
    public function verif_participation($id_user,$id_event){
        $row = $this->pdo->query("SELECT id_evenement FROM participants WHERE id_user = '$id_user' AND id_evenement= '$id_event'")->fetch();
        return $row && $id_event;
    }

    //Récupération des id des evenements auxquels le membre est particicipant
    public function id_events($id_user){
        return $this->pdo->query("SELECT id_evenement FROM participants WHERE id_user = '$id_user'")->fetchAll();
    }
    //Récupération des id des users participants à l'événement 
    public function id_participant($id_event){
        return $this->pdo->query("SELECT id_user FROM participants WHERE id_evenement = '$id_event'")->fetchAll();
    }

    //Récupération des événements avec $id_ville, $dep, $langue1, $langue2
    public function recherche_event1($id_ville, $dep, $langue1, $langue2){
        return $this->pdo->query("SELECT DISTINCT * FROM `{$this->table}`
        WHERE (id_villes = '$id_ville' OR departement ='$dep') 
        AND JSON_CONTAINS(`id_langues`, '$langue1')
        AND JSON_CONTAINS(`id_langues`, '$langue2')") ->fetchAll();
    }
    //Récupération des événements avec $id_ville, $dep, $langue1, $langue2, $theme
    public function recherche_event2($id_ville, $dep, $langue1, $langue2, $theme){
        return $this->pdo->query("SELECT DISTINCT * FROM `{$this->table}`
        WHERE (id_villes = '$id_ville' OR departement ='$dep') 
        AND JSON_CONTAINS(`id_langues`, '$langue1')
        AND JSON_CONTAINS(`id_langues`, '$langue2')
        AND JSON_CONTAINS(`id_themes`, '$theme')") ->fetchAll();
    }

    //Récupération des événements avec $id_ville, $dep, $langue1, $langue2, $theme, $date
    public function recherche_event3($id_ville, $dep, $langue1, $langue2, $theme, $date){
        return $this->pdo->query("SELECT DISTINCT * FROM `{$this->table}`
        WHERE (id_villes = '$id_ville' OR departement ='$dep') 
        AND JSON_CONTAINS(`id_langues`, '$langue1')
        AND JSON_CONTAINS(`id_langues`, '$langue2')
        AND JSON_CONTAINS(`id_themes`, '$theme')
        AND `date` = $date") ->fetchAll();
    }
    //Récupération des événements avec $id_ville, $dep, $langue1, $langue2, $date
    public function recherche_event4($id_ville, $dep, $langue1, $langue2, $date){
        return $this->pdo->query("SELECT DISTINCT * FROM `{$this->table}`
        WHERE (id_villes = '$id_ville' OR departement ='$dep') 
        AND JSON_CONTAINS(`id_langues`, '$langue1')
        AND JSON_CONTAINS(`id_langues`, '$langue2')
        AND `date` = $date") ->fetchAll();
    }

    //Création d'un événement
    public function add_event($nom, $description, $adresse, $date, $debut, $fin, $photos, $photo1, $id_ville, $departement, $id_themes, $id_langues, $id_user){
        $stmt= $this->pdo->prepare("INSERT IGNORE INTO `{$this->table}`(`nom`,`description`,`adresse_lieu`,`date`,`heure`, `heure_fin`, `photo`, `photo1`, `id_villes`, `departement`, `id_themes`, `id_langues`, `id_user`, `validation`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->execute([$nom, $description, $adresse, $date, $debut, $fin, $photos, $photo1, $id_ville, $departement, $id_themes, $id_langues, $id_user, "non"]);
    }
    
}