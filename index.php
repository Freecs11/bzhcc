<?php
session_start();
require_once("db.php");
if(!isset($_SESSION['favoris'])){
	$_SESSION['favoris']=array();	
}

include("inc/top.php");
	
	$req = $pdo -> prepare("SELECT DISTINCT name FROM categories");
	$req -> execute();
	$resultats = $req->fetchAll();
	$req -> closeCursor();
	$annoncesreq = $pdo -> prepare("SELECT * FROM annonces");
	$annoncesreq -> execute();
	$resAnnonces = $annoncesreq -> fetchAll();
	$_SESSION['annonces']= $resAnnonces;
	$_SESSION['categories']= $resultats;
	
	$listAnnonces = array_rand($_SESSION['annonces'],6);
	$annonceAleatoire = array_rand($listAnnonces,1);

?>

<!-- debut de la partie contenu -->
<div class="main">
<div class="sidebar">
<div class="s-main">
	<div class="s_hdr">
		<h2>Catégories</h2>
	</div>
	<div class="text1-nav">
		<ul>
			<?php
			foreach ($_SESSION['categories'] as $key => $value) {
			?>
				<li><a href="search.php?cat=<?php echo $value[0]; ?> "> <?php echo $value[0];?> </a></li>
			<?php
			}
			?>
	    </ul>
	</div>
</div>


</div>

<div class="content">
	<div class="clear"></div>
	<div class="cnt-main">
		<div class="s_btn">
			<ul>
			<?php 
			if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && isset($_SESSION['nom'])){
				echo '<li><h2>Ravi de vous revoir '.$_SESSION['prenom'].'</h2></li>';
				echo '<div class="clear"></div>';
			}else {
				?>
				<li><h2>Bienvenue !</h2></li>
				<li><h3><a href="login.php">Se connecter</a></h3></li>
				<li><h2>Nouveau visiteur ?</h2></li>
				<li><h4><a href="sinscrire.php">S'enregistrer</a></h4></li>
				<div class="clear"></div>
			<?php }
			?>
				
			</ul>
		</div>
	<div class="grid">
	<div class="grid-img">
		<a href="annonce.php?ann=<?php echo $_SESSION['annonces'][$annonceAleatoire]['annonceId'] ?>">
			<img src="data:image/jpeg;base64, <?php echo base64_encode($_SESSION['annonces'][$annonceAleatoire]['image']) ?>"/>			
	</a>
	</div>
	<div class="grid-para">
		<h2>Nouveau sur le site</h2>
		<h3><?php  echo $_SESSION['annonces'][$annonceAleatoire]['title']  ?></h3>
		<p><?php   echo $_SESSION['annonces'][$annonceAleatoire]['description'] ?> </p>
		<div class="btn top">
		<a href="annonce.php?ann=<?php echo $_SESSION['annonces'][$annonceAleatoire]['annonceId'] ?>">Details&nbsp;
		<img src="images/marker2.png" alt="" ></a>
		</div>
	</div>
	<div class="clear"></div>
	</div>
</div>
<div class="cnt-main btm">
	<div class="section group">
				<?php
				foreach ($listAnnonces as $key => $value) {
					
					?>
					<div class="grid_1_of_3 images_1_of_3">
					 <a href="annonce.php?ann=<?php echo $_SESSION['annonces'][$value]['annonceId'] ?>">
					 <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($_SESSION['annonces'][$value]['image'] ); ?>" /> 
					</a>
					 <a href="annonce.php?ann=<?php echo $_SESSION['annonces'][$value]['annonceId'] ?>"><h3>
					<?php  echo $_SESSION['annonces'][$value]['title'] ?></h3></a>
					 <div class="cart-b">
					<span class="price left"><sup>$<?php echo  $_SESSION['annonces'][$value]['price'] ?></sup><sub></sub></span>
				    <div class="btn top-right right"><a href="annonce.php?ann=<?php echo $_SESSION['annonces'][$value]['annonceId'];
					?>&fav=yes">Ajouter à mes favoris</a></div>
				    <div class="clear"></div>
				 </div>
				</div>
			<?php 
				}
			
			?>
		
			</div>
</div>
</div>
<div class="clear"></div>
</div>

<!-- fin de la partie contenu -->
<?php
include("inc/bottom.php");
?>