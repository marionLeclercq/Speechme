<!DOCTYPE html>
<html>
	<head>
		<title>Upload de fichiers avec détection du type MIME</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	</head>
	<body>
	<?php

	if(isset($_POST['envoi'])) {
		echo "Contenu de la variable FILES".var_dump($_FILES)."<br>";
		if(move_uploaded_file($_FILES['userfile']['tmp_name'], 'upload/'.$_FILES['userfile']['name'])) {
			echo "Transfert réussi<br>";
			echo "Il s'agit du fichier :".$_FILES['userfile']['name']."<br>";
			echo "De type mime : ".$_FILES['userfile']['type']."<br>";

		} else
			echo "Echec de l'upload";
	}

    ?>
	<h2>Transfert de fchiers</h2>
	<form enctype="multipart/form-data" action="upload.php" method="post">
		<!-- MAX_FILE_SIZE doit précéder le champ input de type file -->
		<!-- et doit tenir compte de la nature des fichiers attendus -->
		<input type="hidden" name="MAX_FILE_SIZE" value="300000000" />
		<!-- Le nom de l'élément input détermine -->
		<!-- le nom dans le tableau $_FILES -->
		<label for="idfile">Envoyer ce fichier</label>
		<input id="idfile" name="userfile" type="file" />
		<input name ="envoi" type="submit" value="Envoyer le fichier" />
	</form>
</body>
</html>

