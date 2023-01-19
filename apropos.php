<?php
session_start();
include("inc/top.php");
?>

<!-- debut de la partie contenu -->
<div class="main">
<div class="about">
		<div class="abt_para">
	    	 <a href="details.html"><h3>A propos de BreizhCoinCoin :  </h3></a>
		     <p>Les petites annonces en ligne, par rapport aux publications papier, ont comme avantage la simplicité, la gratuité et 
				 la possibilité d’être visible par un plus grand nombre d’acheteurs potentiels (personnes susceptibles d’être intéressées 
				 par le bien ou le service vendu). En effet, 34% de la population utilise internet en Afrique. Ce taux va très certainement 
				 évoluer au cour des années à venir. Le Burkina Faso, compte 4,6 millions d’utilisateurs actifs d’internet par mois et 1,6 
				 millions d’utilisateurs actifs des médias sociaux. Notre pays est la 9ème plus forte croissance dans le monde selon le rapport 
				 Hootsuite 2020.</p>
			<div class="btn top-right"><a href="https://www.fereso.net/quest-ce-quun-site-de-petites-annonces/" target="_blank">En savoir plus</a></div>
		 </div>
		 <div class="abt_img">
			<a href="index.html"><img src="images/pic1.jpg"></a>
		</div>
		<div class="clear"></div>
		<p>Chez BreizhCoinCoin, nous avons depuis toujours le souci de l’humain, du bien-être des collaborateurs, de la préservation d’un équilibre sain entre les journées de travail et la vie privée. Pour continuer de grandir sans changer d’état d’esprit, nous privilégions une organisation horizontale et des méthodes de management modernes et agiles. Nous osons nous remettre en question chaque jour, nous réinventer quand c’est nécessaire, afin d’être toujours plus performants tout en restant fidèles à nos valeurs.</p>
		<div class="btn top-right"><a href="index.html">En savoir plus</a></div>
	</div>
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