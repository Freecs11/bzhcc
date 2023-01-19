<!--A Design by W3layouts
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE HTML>
<html>
<head>
<title>BreizhCoinCoin</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
<link href='//fonts.googleapis.com/css?family=Cabin+Condensed' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="formscript.js"></script>
</head>
<body>
<div class="wrap">
<div class="header">
	<div class="logo">
		<a href="index.php"><img src="images/logo.png" alt="" > </a>
	</div>
	<div class="header-right">
	<div class="contact-info">
		<ul>
			<li><a href="favoris.php">Favoris : <?php echo count($_SESSION['favoris'])?> enregistrés</a></li>
			<?php 
					if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
						echo '<li><a href="ajoutannonce.php" style="color:black;">Ajouter Une Annonce</a></li>';
					}
					if(isset($_SESSION['adminin']) ){
						echo '<li><a href="manager/index.php" style="color:black;">Admin Dashboard</a></li>';
					}
				?>
		</ul>
	</div>
	<div class="menu">
	 	 <ul class="nav">
		
		<li class="active"><a href="index.php" title="Home">Accueil</a></li>
  		<li><a href="apropos.php">Notre concept</a></li>
  	     <li><a href="categories.php">Annonces</a></li>
  		<li><a href="contact.php">Contact</a></li>
		<?php 
			if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
				echo '<li><a href="logout.php">se déconnecter </a></li>';
				echo '<li><a href="compte.php">Mon compte</a></li>';
				
			}
			else{
				echo '<li><a href="sinscrire.php">S\'enregistrer</a></li>';
			}
		?>
	    
  		<div class="clear"></div>
      </ul>
	 </div>
	 </div>
	<div class="clear"></div>
</div>
<div class="hdr-btm pad-w3l">
<div class="hdr-btm-bg"></div>
<div class="hdr-btm-left">
	<div class="search">
	  <form action="javascript:return formsubmit()" onsubmit="window.location.href= formsubmit();">
		<input type="text" value="tapez votre recherche"  id="textSearch">
		<input type="submit" value="Chercher" class="pad-w3l-search"  >
	  </form>
	</div>
	<div class="drp-dwn">
		<select class="custom-select" id="select-1" >
			<option selected="selected">Catégorie</option>
			<?php 
				foreach ($_SESSION['categories'] as $key => $value) {
					?>
				<option value="<?php echo$value[0]; ?>"><?php echo $value[0];?></option>
			<?php }
			?>
		</select>
	</div>
	<div class="txt-right">
		<h3><a href="rechercheavancee.php">Recherche avancée</a></h3>
	</div>
	<div class="clear"></div>
</div>
</div>