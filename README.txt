
	Consignes d'utilisation du site "Speechme"
_________________________________________________________

-> La base de donnée "pt2019-20120_leclercq.sql" est placée dans le dossier "Ressources"
-> Les paramètres a modifié pour votre connexion à la BDD sont dans 3 fichiers:
	* Le fichier "connexion_BdD" du dossier include
	* Les fichiers "authentif.php" et "evenements.php" du dossier " include/classes "

	$host = 'localhost';
	$db   = 'pt2019-2020_leclercq';
	$user = 'root';		=>> ce qui est a modifié si nécessaire.
	$pass = '';
	$charset = 'utf8';

-> Pour accéder au backoffice Administrateur : 	mail : admin@gmail.com
					mot de passe : administrateur

-> Pour accéder au front office membre : 		mail : h@gmail.com		mail : claudine@free.fr	mail : anto@gmail.com
					mdp : password		mdp : claudine 		mdp : antoine06
					
					mail : Nath@free.fr
					mdp : nathalie75

-> Pour remplir les champs "villes", "thèmes" et "langues" des formulaires, Tapez le début du mot, un système d'autocomplétion cherche les mots associés 
	et sélectionnez parmis la liste proposée. Si pas de choix proposé, tapez autre chose afin de trouver dans la liste.

-> Pour la fonctionnalité "mot de passe oublié", le code généré pour la réinitialisation du mot de passe n'est pas envoyé par mail (ne fonctionne pas car le site est en local), 
	il faut donc aller chercher le code dans la table "recuperation" de la BDD.

-> Il y a des évènements crées en BDD pour deux départements: 06 et 75.

-> Lorsque vous créez un évènement et qu'il s'enregistre dans la BDD, il n'ya pas la possibilité par la suite de l'afficher quand l'utilisateur utilise le fonctionnalité "rechercher" car les langues pratiquées sont enregistrées sous format JSON,
et les chiffres sous forme de string entre double quotes. Ce qui bloque la possibilité d'utiliser JSON_CONTAIN qui ne détecte pas ces chaines de caracteres. C'est pour cela que j'ai du enlever les doubles quotes manuellement dans la table, 
pour pouvoir afficher les résultats de recherche.