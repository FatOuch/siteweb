
<?php include_once 'inc/header.php'; ?>


<?php  
//test pour la mise à jour de fichier
$err = array();
$articles = array();
$formValid = false;
$formError = false;
$maxsize = 1024 * 1000; //1ko *1000 = 1Mo
$dirUpload = 'upload/';
// Avec un slash initial dans $dirUpload, le dossier d'upload devra être à la racine du domaine(locahost)
$mimeTypeAllowed = array ('image/jpg','image/jpeg','image/png', 'image/gif');

if (!empty($_POST)) {
	$finfo = new finfo();
	foreach ($_POST as $key => $value) {
		$articles[$key] = trim(strip_tags($value));
	}
	if (empty($_POST['title'])){
		$err[] = 'Le champs titre ne peut être vide !';		
	}
	if (empty($_FILES['img']['size'])) {//On vérifie qu'il n'y ait pas d'image
		/*
		*Par défaut , sans avoir envoyé de fichier
		*$_FILES['img']= array(
							'name'=>'',
							'type'=>'',
							'tmp_name'=>'',
							'error'=>'',
							'size'=>'',
		);
		*/
		$err[] = 'l\'image ne peut être vide!';
	}
	elseif($_FILES['img']['size'] > $maxsize) {// Je vérifie que l'image ne soit pas trop lourde
		$err[] = 'l\'image excède le poids autorisé';
	}
	//in_array(valeur, tableau) : cherche valeur dans tableau
		//vérifiera que le mime type correspond à ceux qui son autorisé dans $mimeTypeAllowed

	$fileMimeType = $finfo->file($_FILES['img']['tmp_name'],FILEINFO_MIME_TYPE);
	if (!in_array($fileMimeType, $mimeTypeAllowed)) { 
		  
		$err[] = 'Le fichier n\'est pas une image !';
	}
	if (empty($_POST['content'])){
		$err[] = 'Vous devez remplir le champ  !';		
	}
	if (empty($_POST['userId']) && !is_numeric($_POST['userId'])){
		$err[] = 'Vous n\'êtes pas identifié!';
	}
	

	if (count($err)>0) {
		$formError = true;
	}
	else{
		//connexion base de donnée
			$bdd = new PDO('mysql:host=localhost; dbname=site_blog;charset=utf8', 'root', '');

			if (!empty($_FILES['img']['name'])) {
				$monNomDeFichier = trim($_FILES['img']['name']);	
			
				$accent = array("à", "é", "î", "ô", "û"," ");
				// $accent = les caractères que l'ont souhaite remplacé
				$accentLess = array("a", "e", "i", "o", "u","_");
				// $accentLess = les valeurs de remplacement dans le même ordre que $accent
				//time().'-'.$_FILES['img']['name']=>la chaîne dans laquelle j'effectue les remplacement
				$nameAccentLess = str_replace($accent, $accentLess, $monNomDeFichier);
				
				$monImgUpload = $dirUpload.time().'-'.$nameAccentLess;
				/*$monImgUpload = $dirUpload.time().'-'.$_FILES['img']['name'];*/

					if (move_uploaded_file($_FILES['img']['tmp_name'], $monImgUpload)) {
			
			// Insertion des données de l'article seulement si le fichier a été uploadé
						$insertArt = $bdd->prepare('INSERT INTO articles(titre,lien_img,content, date) VALUES (:titreArticle, :lienImage, :contenuArticle, NOW())');
						
						$insertArt->bindValue('titreArticle',$articles['title'], PDO::PARAM_STR);
						$insertArt->bindValue('lienImage',$monImgUpload, PDO::PARAM_STR);
						$insertArt->bindValue('contenuArticle',$articles['content'], PDO::PARAM_STR);
			

							if ($insertArt->execute()) {
								$formValid = true;
								$id_article = $bdd->lastInsertId();
							}
							else{
								$formError = true;
								$err[] = 'une erreur est survenue lors de l\'insertion de votre article';
							}
					}

					else{
						$formError = true;
						$err[] = 'une erreur est survenue lors de l\'insertion de votre image';
					}
			}

	}
}


?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Publiez votre article</title>
</head>
<body>
	<?php 

	if ($formError) {
		echo '<p style="color:red">Oups, votre formulaire n\'a pas pu être envoyé pour les raisons suivantes: <br>'. implode('<br>', $err).'</p>';
		
	}
	if ($formValid) {
		echo '<p style="color:green"> Félicitation, votre article vient d\'être envoyé avec succès';
	}


	 ?>
	 <div>
	 <!-- attribut enctype="multipart/form-data" pour accepter les fichiers> -->
		<form method ="POST" enctype="multipart/form-data"> <!-- Si pas d'attribut action le formulaire sera traité sur la même page -->
			<!-- limitation de la taille du fichier par le navuigateur
			#Il faut tout de même faire une vérification en PHP -->
			<h2>Faites vous plaisir, écrivez votre article ! </h2>
			<input type="hidden" name="userId" value="1">
			<label for="title">Titre</label>
			<input type="text" id="title" name="title" placeholder="Votre titre ici">

			<label for="img">Url de votre image</label>
			<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $maxsize; ?>">
			<input type="file" id="img" name="img" placeholder="ex: http://www.exemple.fr">
			

			<br>
			<label for="content">Article</label>
			<textarea name="content" id="content" cols="30" rows="10"></textarea>
			
			<br>
			<input type="submit" value="Envoyer">
		</form>
	</div>
</body>
</html>





 <?php include_once 'inc/footer.php'; ?>