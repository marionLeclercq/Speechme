<?php
class login {

    private $table;
    private $pdo;
    
    // '$table' est la table contenant les données
    // d'authentification (login et mot de passe)
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
    
     // retourne le login de l'utilisateur
     public function user() {
        return $_SESSION[ "prenom" ];
    }
    
    // si l'utilisateur n'est pas authentifié
    // redirige vers la page d'accueil du site
    public function checkLogin($role) {
        if ( ! isset( $_SESSION[ "email" ] ) && $role == "user") {
            header("Location: ./index.php");
            die();
        }
        if (( ! isset( $_SESSION[ "email" ] ) && $role == "admin")) {
            header("Location: ../index.php");
            die();
        }
        
    }
     // teste si 'enregistrement.php' a échoué
     public function badSignUp() {
        return isset( $_GET["badsignup"] );
    }

    // retourne le message d'erreur relatif
    public function badSignUpMsg() {
        if(isset( $_GET["badsignup"])){
            switch ( $_GET["badsignup"] )
            {
                case "1": $msg = "Veuillez renseignez votre prénom"; break;
                case "2": $msg = "Le format de l'email est incorrect"; break;
                case "3": $msg = "Cet email est déjà utilisé"; break;
                case "4": $msg = "Le mot de passe doit avoir minimum 8 caractères"; break;
                case "5": $msg = "Le mot de passe et la vérification sont différents";break;
                case "6": $msg = "Le mot de passe a bien été modifié!";break;
                case "7": $msg = "Vous êtes bien enregistré, retournez à la page connexion pour vous connectez";break;
                case "8": $msg = "Veuillez accepter les conditions générales pour vous inscrire.";break;
            }
            return $msg;
        }
    }
    
    // teste si 'connexion.php' a échoué
    public function badSignIn() {
        return isset( $_GET["badsignin"] );
    }
    
    // retourne le message d'erreur relatif 
    public function badSignInMsg() {
        if(isset( $_GET["badsignin"])){
            switch ( $_GET["badsignin"] )
            {
                case "1": $msg = "Mauvais login/mot de passe";break;
                case "2": $msg = "Mot de passe modifié !";break;
            }
        return $msg;
        }
    }

    // retourne le rôle de l'utilisateur '$login'
    public function getRole($login) {
        return $this->pdo->query("SELECT `role` FROM {$this->table} WHERE email = '$login'")->fetch();
    }
    
    // effectue le 'signin' avec :
        // '$login' : le login proposé par l'utilisateur
        // '$password' : le password proposé par l'utilisateur
        
        public function doSignIn($login,$password) {
            if ( $this->checkLoginPassword($login,$password) ) {
                $_SESSION[ "email" ] = $login;
                $name = $this->getName($login);
                $role = $this->getRole($login);
                $_SESSION[ 'prenom' ] = $name[ 'prenom' ];
                $_SESSION[ "role" ] = $role['role'];
                $_SESSION[ "id" ] = $name['id'];
		        if ( $role['role'] == 'admin' ) {
                    header('Location: backoffice/index_BO.php');
                } else header("Location: user.php");
            }
            else
            {
                header("Location: connexion.php?badsignin=1");
            }
        }

        // effectue le 'signup' avec :
    // '$login' : le login proposé par l'utilisateur
    // '$password1' : le password proposé par l'utilisateur
    // '$password2' : la répétition du password

    public function doSignUp($prenom,$login,$password,$password2,$id_ville,$conditions) {
        if ( strlen($prenom) == 0 ) {
            header("Location: enregistrement.php?badsignup=1");
            die();		
        }
        if ( ! preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i", $login) ){
            header("Location: enregistrement.php?badsignup=2");
            die();
        }
        if ( $this->loginExists($login) ) {
            header("Location: enregistrement.php?badsignup=3");
            die();
        }
        if ( strlen( $password ) < 8 ) {
            header("Location: enregistrement.php?badsignup=4");
            die();
        }
        if ( $password != $password2 ) {
            header("Location: enregistrement.php?badsignup=5");
            die();
        }
        if ( !$conditions ) {
            header("Location: enregistrement.php?badsignup=8");
            die();
        }
        $this->addUser($prenom,$login,$password,$id_ville);
        header("Location: enregistrement.php?badsignup=7");
     
    }
        
        // retourne le prénom de l'utilisateur
        // de login '$login'
        public function getName($login) {
            return $this->pdo->query("SELECT id,`prenom` FROM {$this->table} WHERE email = '$login'")->fetch();
        }
    
        // retourne true si '$login' est un login correct et si '$password'
        // est le password correspondant, retourne false sinon    
        private function checkLoginPassword($login,$password) {
            $password_hash =  password_hash($password,PASSWORD_DEFAULT);
            $row = $this->pdo->query("SELECT `password` FROM {$this->table} WHERE email = '$login'")->fetch();
            $pwd = $row['password'];
            return password_verify($password, $pwd);
        }
        // retourne true si '$login' est un login existant
        private function loginExists($login) {
        return $this->pdo->query("SELECT * FROM {$this->table} WHERE email = '$login'")->fetch();
    }

        // ajoute un nouvel utilisateur dans la table
        // de prénom '$prenom', de login'$login'
        // et de mot de passe '$password'
        private function addUser($prenom, $login,$password, $id_ville) {
            $stmt = $this->pdo->prepare("INSERT INTO `{$this->table}`(`prenom`,`email`,`password`,`role`, `photo`, `description`, `id_villes`) VALUES (?,?,?,?,?,?,?)");
            $stmt->execute([$prenom, $login, password_hash($password,PASSWORD_DEFAULT),'user','upload/membre.png','', $id_ville]);
        }

        // Modification de l'url de la photo de profil de l 'utilisateur dans la table 'user'
        public function addPhoto($photo, $login){
            $insert_photo = $this->pdo ->query("UPDATE `{$this->table}` SET photo = './$photo' WHERE email = '$login'");
        }
         //Récuperation de l'url de la photo de profil de l'utilisateur dans la table 'user'
         public function photo($login){
            return $this->pdo ->query("SELECT photo FROM `{$this->table}` WHERE email = '$login'")-> fetch();
        }

        //Récupération de l'id de la ville de l'utilisateur
        public function affichage_id_ville($login){
            $id_villes= $this->pdo ->query("SELECT id_villes FROM `{$this->table}` WHERE email = '$login'")-> fetch();
            return $id_ville = $id_villes['id_villes'];
        }

        //Récupération du nom de la ville de l'utilisateur
        public function affichage_ville($login){
            $id_villes= $this->pdo ->query("SELECT id_villes FROM `{$this->table}` WHERE email = '$login'")-> fetch();
            $id_ville = $id_villes['id_villes'];
            return $nom_ville = $this->pdo -> query("SELECT ville_nom_reel FROM `villes` WHERE id = '$id_ville'")-> fetch();
        }
          //Récupération du code département de la ville de l'utilisateur
        public function code_dep($nom_ville){
        return $this->pdo->query("SELECT ville_departement FROM `villes` WHERE ville_nom_reel= '$nom_ville'")->fetch();
        
    }
        //Récupération de la description de l'utilisateur
        public function affichage_descr($login){
            return $desc = $this->pdo ->query("SELECT `description` FROM `{$this->table}` WHERE email = '$login'")-> fetch();
        }

        //Modification des différentes informations de l'utilisateur
        public function modifications($login, $colonne, $modif){
            $this->pdo ->query("UPDATE `{$this->table}` SET `$colonne` = '$modif' WHERE email = '$login'");
        }  

        //Insertion des id (`id_user`,`id_langues_parlees`) dans la table assoc_user_langues_parlees
        public function insert_id($login, $id_langue_parlee){
            $id = $this->pdo ->query("SELECT `id` FROM `{$this->table}` WHERE email = '$login'")-> fetch();
            $id_user = $id['id'];
            $stmt = $this->pdo ->prepare("INSERT IGNORE INTO `assoc_user_langues_parlees`(`id_user`,`id_langues_parlees`) VALUES (?,?)");
            $stmt->execute([$id_user, $id_langue_parlee]);
        }
        //Insertion des id (`id_user`,`id_langues_apprentissage`) dans la table assoc_user_langues_apprentissage
        public function insert_id_learn($login, $id_langue_apprentissage){
            $id = $this->pdo ->query("SELECT `id` FROM `{$this->table}` WHERE email = '$login'")-> fetch();
            $id_user = $id['id'];
            $stmt = $this->pdo ->prepare("INSERT IGNORE INTO `assoc_user_langues_apprentissage`(`id_user`,`id_langues_apprentissage`) VALUES (?,?)");
            $stmt->execute([$id_user, $id_langue_apprentissage]);
        }

          //Récupération des langues parlées de l'utilisateur grâce aux ids correspondants

        public function langues_parlees($login){
            $id = $this->pdo ->query("SELECT `id` FROM `{$this->table}` WHERE email = '$login'")-> fetch();
            $id_user = $id['id'];
            return $id_langues = $this->pdo ->query("SELECT `id_langues_parlees` FROM `assoc_user_langues_parlees` WHERE id_user = '$id_user'")-> fetchAll(); 
            
        }
        //Récupération des langues en apprentissage de l'utilisateur grâce aux ids correspondants

        public function langues_apprentissage($login){
            $id = $this->pdo ->query("SELECT `id` FROM `{$this->table}` WHERE email = '$login'")-> fetch();
            $id_user = $id['id'];
            return $id_langues = $this->pdo ->query("SELECT `id_langues_apprentissage` FROM `assoc_user_langues_apprentissage` WHERE id_user = '$id_user'")-> fetchAll(); 
            
        }

        //verification nouveau mot de passe = à sa répétition 
        public function verif_pwd($login,$password,$password2){
            if ( strlen( $password ) < 8 ) {
                header("Location: profil.php?badsignup=4");
                die();
            }
            if ( $password != $password2 ) {
                header("Location: profil.php?badsignup=5");
                die();
            }
            $this->modif_pwd($login,$password);
            header("Location: profil.php?badsignup=6");
        }

        //Modification du mot de passe de l'utilisateur dans la bdd
        public function modif_pwd($login,$password){
            $password_hash = password_hash($password,PASSWORD_DEFAULT);
            return $this->pdo ->query("UPDATE `{$this->table}` SET `password` = '$password_hash' WHERE email = '$login'");
        }

        /*********************** avec ID *************************/

        //Récupération informations utilisateur avec son id
        public function infos($id){
            return $this->pdo ->query("SELECT * FROM `{$this->table}` WHERE id = '$id'")-> fetch();
        }

        //Récupération du nom de la ville de l'utilisateur
        public function display_ville($id){
            $id_villes= $this->pdo ->query("SELECT id_villes FROM `{$this->table}` WHERE id = '$id'")-> fetch();
            $id_ville = $id_villes['id_villes'];
            return $nom_ville = $this->pdo -> query("SELECT ville_nom_reel FROM `villes` WHERE id = '$id_ville'")-> fetch();
        }
        //Récupération des langues parlées par l'utilisateur
        public function speaklang($id){
            $id = $this->pdo ->query("SELECT `id` FROM `{$this->table}` WHERE id = '$id'")-> fetch();
            $id_user = $id['id'];
            return $id_langues = $this->pdo ->query("SELECT `id_langues_parlees` FROM `assoc_user_langues_parlees` WHERE id_user = '$id_user'")-> fetchAll();
        }
        //Récupération des langues en apprentissage de l'utilisateur

        public function learnlang($id){
            $id = $this->pdo ->query("SELECT `id` FROM `{$this->table}` WHERE id = '$id'")-> fetch();
            $id_user = $id['id'];
            return $id_langues = $this->pdo ->query("SELECT `id_langues_apprentissage` FROM `assoc_user_langues_apprentissage` WHERE id_user = '$id_user'")-> fetchAll(); 
        }

        //Suppression du compte utilisateur
        public function suppression_user($id){
        return $this->pdo ->query("DELETE FROM `{$this->table}` WHERE id= '$id'");
        }
}