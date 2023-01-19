<?php
session_start();
require_once("db.php");
include("inc/top.php");
// charge favoris from database if they are not already loaded
if(isset($_SESSION['id']) && !isset($_SESSION['favoris'])){
	$sql = "SELECT * FROM favs WHERE userId = ".$_SESSION['id'];
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	$favsa = $stmt->fetchAll();
	$_SESSION['favoris'] = array();
	foreach ($favsa as $key => $value) {
		$annoncefav = $value['annonId'];
		$reqAnnonce = $pdo->prepare('SELECT * FROM annonces WHERE annonceId=' . $annoncefav);
		$reqAnnonce->execute();
		$annonce = $reqAnnonce->fetch();
		array_push($_SESSION['favoris'], $annonce);
	}
}
$favs = $_SESSION['favoris'];
if(isset( $_GET['delall'] ) ) {
	foreach ($_SESSION['favoris'] as $key => $value) {
		if (in_array($value, $_SESSION['favoris'], true)) {
			unset($_SESSION['favoris'][array_search($value, $_SESSION['favoris'])]);
		}
	}
	header('location: index.php');
}



?>

<!-- debut de la partie contenu -->
<div class="main">
	<div class="ser-main">
		<h4>Vos favoris</h4>
		<div class="ser-para">
			<p>
			<?php 
			if(empty($favs)) {
				echo "Vous n'avez pas encore de favoris";
			} else {
				echo "Vous avez ".count($favs)." favoris";
			}
			?>
			
		</p>
		</div>

		<!-- debut de  ligne de 3 produits -->
		<?php
		$number = 1;
		foreach ($favs as $key => $value) {
		?>
			<div class="ser-grid-list">
				<h5><?php echo $value['title'] ?></h5>
				<img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($value['image']); ?>" />
				<p><?php echo $value['description'] ?></p>
				<div class="btn top"><a href="annonce.php?ann=<?php echo $value['annonceId'];
																?>&del=yes">Supprimer de mes favoris</a></div>
			</div>
		<?php $number++;
			if ($number % 3 == 1) {
				echo '<div class="clear"></div>';
			}
		}
		?>


		<?php
		if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
		?>
			<div class="clear">
				<div class="btn top"><a href="favoris_imprimer.php">Imprimer mes favoris</a></div>
			</div>
			<div class="clear">
				<div class="btn top"><a href="favoris_mail.php">Envoyer par mail</a></div>
			</div>

		<?php
		}


		?>
		<div class="clear"></div>
		<a href="favoris.php?delall=yes">
		<button style="background:#3630a3;color:white;padding: 15px 32px;margin-top:2em;border:none;text-align: center;
		text-decoration: none;
		display: inline-block;
		font-size: 16px;">
			DELETE ALL</button></a>
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