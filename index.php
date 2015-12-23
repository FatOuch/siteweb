<?php include_once 'inc/header.php'; ?>
<?php include_once 'inc/fonctions.php'; ?>

	<main>


<?php 
// Je crée juste une requête qui m'affichera tous les articles dans cette page, qui correspond à ma page principale

$bdd = new PDO('mysql:host=localhost;dbname=site_blog;charset=utf8','root','');
$rep = $bdd ->query('SELECT * FROM articles');
$result = $rep->fetchAll(PDO::FETCH_ASSOC);

	echo '<div>';
		echo '<h1>Bienvenue sur mon blog</h1>';

		foreach ($result as $value) {
		
			echo '<article>';
			echo '<h2>'.$value['titre'].'</h2>';
			echo '<img src="'. $value['lien_img'].'">' ;
			
			echo '<p>'.cutString($value['content'], 200).' <a href="lecture_article.php?id='.$value['id'].'">suite...</a></p>';
			echo '</article>';
	
		}
	echo '<div>';


?> 

		
	</main>

<?php include_once 'inc/footer.php'; ?>