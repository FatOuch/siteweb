<?php include_once 'inc/header.php'; ?>
<div>
	<form method="get">
		<label for="champs" class="labelSearch">Recherchez un utilisateur</label>
		<input type="text" name="search" class="search" placeholder="entrer nom d'utilisateur">
		<button type="submit" name="submit">Envoyer</button>
	</form>
</div>
<?php 
$bdd = new PDO('mysql:host=localhost;dbname=site_blog;charset=utf8','root','');

//--------------------------------MA FONCTION POUR TROUVER UN UTILISATEUR-------------------------------


	// Si on fait une recherche
	if(isset($_GET['search']) && !empty($_GET['search'])){
		$recherche = trim($_GET["search"]);

		$reqSearch = $bdd->prepare('SELECT * FROM users WHERE nickname LIKE :recherche');
		$reqSearch->bindValue(':recherche', '%'.$recherche.'%', PDO::PARAM_STR);
		if($reqSearch->execute()){
		// Selectionne les utilisateurs en fonction de la recherche
			$rechUsers = $reqSearch->fetchAll(PDO::FETCH_ASSOC);
		} 
		else {
			$erreurs[] = 'Une erreur est survenue...';
		}
	}
	// Sinon on arrive direct sur la page
	else {
		$recupUser = $bdd ->prepare('SELECT * FROM users ORDER BY date_registered DESC');
		// DESC va trier les les dates d'enregistrement par odre numérique
		if($recupUser->execute()) {
			// Selectionne tout les utilisateurs
			$rechUsers = $recupUser->fetchAll(PDO::FETCH_ASSOC);
		}
	}


//---------------------------------------MON AFFICHAGE UTILISATEUR--------------------------------------


	echo '<div>';
		echo '<h2 >Mes utilisateurs</h2>';
		// Affichage des utilisateurs directement ou provenant de la recherche
		if(isset($rechUsers) && !empty($rechUsers)){
			foreach ($rechUsers as $column) {
				echo '<article>';
					echo '<h2>Utilisateur:</h2><br/><h3>'.$column['nickname'].'</h3>';
					echo '<p style="font-style:bold;"> date d\'enregistrement '.date('d/m/Y H:i', strtotime($column['date_registered'])).'</p>';
				echo '</article>';
			}
		}

	echo '</div>';


?>



<?php include_once 'inc/footer.php'; ?>
