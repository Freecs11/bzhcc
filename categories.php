<?php
session_start();
include("inc/top.php");

?>

<!-- debut de la partie contenu -->
<div class="main">
<div class="ser-main">
	<h4>Nos annonces</h4>
	<div class="ser-para">
	<p>Voici toutes les annonces disponibles actuellement sur le site </p>
	</div>

    <!-- debut de  ligne de 3 produits -->    
    
	<?php
	$number = 1;
	foreach ($_SESSION['annonces'] as $key => $value) {
		?>
		<div class="ser-grid-list">
		<h5><?php echo $value['title']   ?></h5>
		<img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($value['image'] ); ?>" /> 
		<p><?php echo $value['description'] ?></p>
		<div class="btn top"><a href="annonce.php?ann=<?php echo $value['annonceId'];
					?>">En savoir plus</a></div>
		</div>

	<?php $number++;
		if($number%3==1 ){
			echo '<div class="clear"></div>';
		}
		
	} ?>
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
				<li><a href="search.php?cat=<?php echo $value[0]; ?> "> <?php echo $value[0];?> </a></li>
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
