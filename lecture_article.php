
<?php include_once 'inc/header.php'; ?>
<?php 

		$bdd = new PDO('mysql:host=localhost;dbname=site_blog;charset=utf8','root','');
		$reponse = $bdd ->prepare('SELECT * FROM articles WHERE id = :idDeMonArticle'); // :id est une variable , intéligente sécurisera les infos des id en bas
		$reponse->bindValue(':idDeMonArticle', $_GET['id'], PDO::PARAM_INT);
			if($reponse->execute()){ 
				$article = $reponse->fetch(PDO::FETCH_ASSOC);
			}
			else{
				echo 'Erreur de parcours, veuillez revenir ultérieurement sur cette page';
			}

			if (isset($article) && !empty($article)) {
					echo '<div>';
							echo '<article>';
								echo '<h2>'.$article['titre'].'</h2>';
								echo '<img src="'. $article['lien_img'].'">' ;
								echo '<p>'.$article['content'].'</p>';
								echo '<p ><a class="liencom" href="publication_com.php?id='. $article['id'].'">Commentez cette article...</a></p>';

							echo '</article>';

						echo '</div>';
			}
//-------------------------------------------------AFFICHAGE DE MES COMMENTAIRES & AUTEURS DES COMMENTAIRES------------------------------------------------------------------
//Je vais afficher toutes les commentaires que j'ai reçu pour chaque article



//// J'affiche le commentaire d'un utilisateur
$afficheCom = $bdd->prepare('SELECT * FROM comments WHERE id_article = :idDeMonArticle'); 
$afficheCom->bindValue(':idDeMonArticle', $article['id'], PDO::PARAM_INT);
if ($afficheCom->execute()) {
	$commentaires = $afficheCom->fetchAll(PDO::FETCH_ASSOC);
}

//------------------------------------------------------------------------------------

if(isset($commentaires) && !empty($commentaires)){

	foreach ($commentaires as $col) {

		$afficheUser = $bdd->prepare('SELECT nickname FROM users WHERE id = :idDeMonPseu');
		$afficheUser->bindValue(':idDeMonPseu', $col['user_id'], PDO::PARAM_INT);

		if ($afficheUser->execute()){
			$user2 = $afficheUser->fetch(PDO::FETCH_ASSOC);
			$commentBy = $user2['nickname'];
		}

		if(!isset($user2) || empty($user2)){
			$commentBy = 'Anonyme';
		}

			/*var_dump($afficheUser->errorInfo());*/
		
		echo '<div>';
			echo '<article id="commentaires">';

				echo '<h2 class="titlecom">Commentaire de: </h2>'.'<br><h2 class="surnom">'. 
				$commentBy .'</h2><br><h2 class="heurecom" style="font-style: italic">'. 
				$col['date'].'</h2>';

				echo '<p>'. $col['comment'].'</p>';

			echo '</article>';

		echo '</div>';
	}
}

/*$afficheCom->execute(array('idDeMonArticle' => $_GET['id']));*/

//// J'affiche le pseudo de l'utilisateur qui a écrit ce commentaire
/*$afficheUser = $bdd->prepare('SELECT * FROM users WHERE user_id ='. $_GET['id']); 
$afficheUser->execute(array('idDuUser' => $_GET['id'] = ('')));
$affichage2 = $afficheUser->fetch(PDO::FETCH_ASSOC);
*/


else{
	
	echo '<div>';
		echo '<article id="commentaires">';
			echo '<h2 class="pasdecom">aucun commentaires sur cette article</h2>';
		echo '</article>';
	echo '</div>';

}


			
?>


<?php include_once 'inc/footer.php'; ?>
