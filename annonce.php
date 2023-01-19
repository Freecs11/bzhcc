<?php
require_once("db.php");
session_start();
include("inc/top.php");
$annonceid = $_GET['ann'];

$reqAnnonce = $pdo->prepare('SELECT * FROM annonces WHERE annonceId=' . $annonceid);
$reqAnnonce->execute();
$annonce = $reqAnnonce->fetch();
$reqAnnonce->closeCursor();
$req = $pdo->prepare('SELECT * FROM annonces WHERE categorie="' . $annonce['categorie'] . '"');
$req->execute();

//fav
if (isset($_GET['fav'])) {
	if (!in_array($annonce, $_SESSION['favoris'], true)) {
		$_SESSION['favoris'][] = $annonce;
	}
}
//fav
if (isset($_GET['del'])) {
	if (in_array($annonce, $_SESSION['favoris'], true)) {
		unset($_SESSION['favoris'][array_search($annonce, $_SESSION['favoris'])]);
	}
}

$resCat = $req->fetchAll();
if (count($resCat) > 2) {
	$resrandCat = array_rand($resCat, 3);
} else {
	$resrandCat = array_rand($resCat, count($resCat));
}
?>

<!-- debut de la partie contenu -->
<div class="main">
	<div class="details">
		<div class="product-details">
			<div class="images_3_of_2">
				<div id="container">
					<div id="products_example">
						<div id="products">
							<div class="slides_container">
								<a href="#"><img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($annonce['image']); ?>" /></a>
							</div>
							<ul class="pagination">
								<li><a href="#"><img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($annonce['image']); ?>"  width="30%" height="30%"   /></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<div class="desc span_3_of_2">
				<h2><?php echo $annonce['title'] ?></h2>
				<p><?php echo $annonce['description'] ?></p>
				<div class="price">
					<p>Prix: <span><?php echo $annonce['price'] ?>$</span></p>
				</div>
				<div class="wish-list">
					<ul>
						<li class="wish"><a href="annonce.php?ann=<?php echo $annonce['annonceId'] ?>&fav=yes">Ajouter à mes favoris</a></li>
					</ul>
				</div>
			</div>
			<div class="clear"></div>
		</div>

		<div class="content_bottom">
			<div class="text-h1 top1 btm">
				<h2>Annonces qui pourraient vous intéresser</h2>
			</div>
			<div class="div2">
				<div id="mcts1">
					<?php
					if (!is_integer($resrandCat)) {
						foreach ($resrandCat as $key => $value) {
					?>
							<div class="w3l-img">
								<a href="annonce.php?ann=<?php echo $resCat[$value]['annonceId']; ?>">
								<img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($resCat[$value]['image']); ?>" />
							</a>
							</div>
					<?php }
					}
					?>
					<div class="clear"></div>
				</div>
			</div>
		</div>
	</div>

	<div class="sidebar">
		<div class="s-main">
			<div class="s_hdr">
				<h2>Categories</h2>
			</div>
			<div class="text1-nav">
				<ul>
					<?php
					foreach ($_SESSION['categories'] as $key => $value) {
					?>
						<li><a href="search.php?cat=<?php echo $value[0]; ?> "> <?php echo $value[0]; ?> </a></li>
					<?php	}
					?>
				</ul>
			</div>
		</div>
	</div>
	<div class="clear"></div>
</div>
<!-- fin de la partie contenu -->
<?php
include("inc/bottom.php");
?>