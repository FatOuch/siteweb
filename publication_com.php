<?php include_once 'inc/header.php'; ?>

<?php  
$post = array();
$err = array();
$errorForm = false;
$formValid = false;
// On vérifie notre formulaire
if(!empty($_POST)){
	foreach ($_POST as $key => $value) {
		//On nettoie $post et on le recréer dans $post
		$post[$key] = trim(strip_tags($value));
	}

	if (empty($_POST['nickname'])){
	$err[] = 'Vous devez inscrire un pseudo dans ce champs!';		
	}
	if (empty($_POST['com']) && strlen($_POST['com']) < 5){
	$err[] = 'Vous ne pouvez pas soumettre un commentaire sans contenu 
	ou inférieur à 5 caractères!';		
	}
	if (empty($_POST['id_article']) && !is_numeric($_POST['id_article'])){
	$err[] = 'Pas d\'article sélectionné !';
	}
	//il y a des erreurs !
	
	if (count($err)>0) {
		$errorForm = true;
	}


	else{// Notre formulaire est valide, on sauvegarde !
		//Permet la connexion vers la base de données "mon blog"
		$bdd = new PDO('mysql:host=localhost;dbname=site_blog;charset=utf8', 'root', '');

		
//------------------------je sélectionne un utilisateur afin de vérifier son existence----------------------------

		$checkUser= $bdd->prepare('SELECT id FROM users WHERE nickname = :pseudo');
		// précisément je vais aller sélectionner l'id de la table users qui contient la colonne nickname
		// j'effectue une requête de sélection sur mon tableau $post
		$checkUser->bindValue(':pseudo', $post['nickname'], PDO::PARAM_STR);
		$checkUser->execute();

		$user = $checkUser->fetch(PDO::FETCH_ASSOC);
		// Je récupère l'id utilisateur

		if (isset($user['id']) && !empty($user['id'])) {
			$utilisateur_id = $user['id'];
			/*$err[] = 'Yeah ! tu existes déjà !';*/
		}
		
//-----------------------Sinon j'insère l'utilisateur s'il n'existe pas-----------------------------------------
		else{
			// Dans cette requête, si mon utilisateur n'existe pas encore, 
			//j'enregistre le pseudo qu'il a renseigné dans le formulaire de commentaire
			$resUser = $bdd->prepare('INSERT INTO users (nickname,date_registered) VALUES (:pseudo, NOW())');
			$resUser->bindValue(':pseudo', $post['nickname'], PDO::PARAM_STR);
			$resUser->execute();
			// Je récupère le dernier ID insérer de la première requête
			$utilisateur_id = $bdd->lastInsertId();
		}

		if(!empty($utilisateur_id)){
			// je récupère le $utilisateur_id(qu'il ait été déjà enregistré ou pas), 
			//et je fais en sorte que son résultat s'affiche dans ma colonne 'user_id' de mon tableau 'comments' dans ma base de données
			$resCom = $bdd->prepare('INSERT INTO comments (comment, id_article, user_id, date) VALUES (:comment, :id_article, :id_user, NOW())');
			$resCom->bindValue(':comment', $post['com'], PDO::PARAM_STR);
			$resCom->bindValue(':id_article', $post['id_article'], PDO::PARAM_INT);
			$resCom->bindValue(':id_user', $utilisateur_id, PDO::PARAM_INT);// Comme dit ici j'ai bien récupéré le résultat de ma requête sur '$utilisateur_id' 

			if($resCom->execute()){// Exécute la requete quand même
				$formValid = true;
			}
			
		}
		else{
			$errorForm = true;
			$err[] = '2. Une erreur est survenue, recommencez :(';
		}	

	}

}
		//IMon ancienne requête ---------------------------------------------------------COMMENTS
		//*$res = $bdd->prepare('INSERT INTO comments (comment, date, id_article) VALUES (:commentArticle, NOW(), :idDeMonArticle)');
		//*$res->bindValue(':commentArticle', $post['com'], PDO::PARAM_STR);
		//*$res->bindValue(':idDeMonArticle', $post['id_article'], PDO::PARAM_INT);

		//*if($res->execute()){// Exécute la requete quand même
		//*	$formValid = true;
		//*}*/
		//IMon ancienne requête ---------------------------------------------------------COMMENTS

		
		#*******************************************************************DEBUGGAGE************
		/*print_r($res2->errorInfo()); */

		/*$res2->execute() or die(print_r($res2->errorInfo()));*/
		#*******************************************************************DEBUGGAGE************
		
		


?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Publiez votre commentaire</title>
</head>
<body>
	<?php 
	if($errorForm){
		echo '<p style="color:red;">Votre commentaire n\'a pas pu être envoyé pour les raisons suivantes: <br>'. implode('<br>', $err).'</p>';
	}

	if($formValid){
		echo '<p style="color:green;">Félicitation votre commentaire vient d\'être envoyé avec succès</p>';
	}

	?>
	<div>
	
		<form method="POST" action="">
			<h2>Ecrivez votre commentaire ! </h2>
			<input type="hidden" name="id_article" value="<?php echo $_GET['id']; ?>">

			<label for="nickname">Pseudo</label>
			<input type="text" id="nickname" name="nickname" placeholder="Votre pseudo ici">

			<label for="">Votre commentaire</label>
			<textarea name="com" id="com" cols="30" rows="10"></textarea>

			<input type="submit" value="Envoyer">

		</form>
		<

	</div>
<?php include_once 'inc/footer.php'; ?>
</body>
</html>