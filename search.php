<?php
session_start();
include_once("db.php");
include("inc/top.php");
if(isset($_GET['cat'])){
    $categorie = $_GET['cat'];
}else if (isset($_GET['selection'] )){
    $categorie = $_GET['selection'];
}
if(isset($_GET['textSearch'])){
    $textsearched = $_GET['textSearch'];
}
if(isset($_POST['min'])){
	$min = $_POST['min'];
}
if(isset($_POST['max'])){
	$max = $_POST['max'];
}
if(isset($_POST['titre'])){
	$titre = $_POST['titre'];
}
if(isset($_POST['selection'])){
	$categorie = $_POST['selection'];
}
if(isset($_POST['textSearch'])){
	$textsearched = $_POST['textSearch'];
}


// search the products by name and category and by a min-max trench
if(isset($_POST['min']) && isset($_POST['max']) && isset($_POST['titre']) && isset($_POST['selection'])){
	$sql = 'SELECT * FROM annonces WHERE title LIKE "%'.$titre.'%" AND categorie = '.GetCategorieId($categorie).' AND price >= '.$min.' AND price <= '.$max.'';
$resultat = $pdo->query($sql);
}else if(isset($_POST['min']) && isset($_POST['max']) && isset($_POST['titre'])){
	$sql = "SELECT * FROM annonces WHERE title LIKE '%$titre%' AND price >= $min AND price <= $max";
$resultat = $pdo->query($sql);
}else if(isset($_POST['min']) && isset($_POST['max']) && isset($_POST['selection'])){
	$sql = 'SELECT * FROM annonces WHERE categorie = '.GetCategorieId($categorie).' AND price >= '.$min.' AND price <= '.$max.'';
$resultat = $pdo->query($sql);
}else if(isset($_POST['min']) && isset($_POST['titre']) && isset($_POST['selection'])){
	$sql = 'SELECT * FROM annonces WHERE title LIKE "%'.$titre.'%" AND categorie = '.GetCategorieId($categorie).' AND price >= '.$min.'';
$resultat = $pdo->query($sql);
}else if(isset($_POST['max']) && isset($_POST['titre']) && isset($_POST['selection'])){
	$sql = 'SELECT * FROM annonces WHERE title LIKE "%'.$titre.'%" AND categorie = '.GetCategorieId($categorie).' AND price <= '.$max.'';
$resultat = $pdo->query($sql);
}else if(isset($_POST['min']) && isset($_POST['titre'])){
	$sql = "SELECT * FROM annonces WHERE title LIKE '%$titre%' AND price >= $min";
$resultat = $pdo->query($sql);
}else if(isset($_POST['max']) && isset($_POST['titre'])){
	$sql = "SELECT * FROM annonces WHERE title LIKE '%$titre%' AND price <= $max";
$resultat = $pdo->query($sql);
}else if(isset($_POST['min']) && isset($_POST['selection'])){
	$sql = 'SELECT * FROM annonces WHERE categorie = '.GetCategorieId($categorie).' AND price >= '.$min.'';
$resultat = $pdo->query($sql);
}else if(isset($_POST['max']) && isset($_POST['selection'])){
	$sql = 'SELECT * FROM annonces WHERE categorie = '.GetCategorieId($categorie).' AND price <= '.$max.'';
$resultat = $pdo->query($sql);
}else if(isset($_POST['titre']) && isset($_POST['selection'])){
	$sql = 'SELECT * FROM annonces WHERE title LIKE "%'.$titre.'%" AND categorie = \''.GetCategorieId($categorie).'\'';
$resultat = $pdo->query($sql);
}else if(isset($_POST['titre'])){
	$sql = "SELECT * FROM annonces WHERE title LIKE '%$titre%'";
	$resultat = $pdo->query($sql);
}else if(isset($_POST['min'])){
	$sql = "SELECT * FROM annonces WHERE price >= $min";
$resultat = $pdo->query($sql);
}else if(isset($_POST['max'])){
	$sql = "SELECT * FROM annonces WHERE price <= $max";
	$resultat = $pdo->query($sql);
}else if(isset($_POST['selection'])){
$sql = 'SELECT * FROM annonces WHERE categorie = '.GetCategorieId($categorie).'';
$resultat = $pdo->query($sql);
}else{
	$sql = "SELECT * FROM annonces";
$resultat = $pdo->query($sql);
}

if(isset($textsearched) && $textsearched!=""){
        if($categorie!='Catégorie'){
            $req = $pdo-> prepare('SELECT * FROM annonces WHERE title LIKE "%'.$textsearched.'%" AND categorie="'.getCategorieId($categorie).'"');
            $req -> execute();    
        }else{
            $req = $pdo-> prepare('SELECT * FROM annonces WHERE title LIKE "%'.$textsearched.'%"');
            $req -> execute();  
        }
    }
    else{
    $req = $pdo-> prepare('SELECT * FROM annonces WHERE categorie="'.GetCategorieId($categorie).'"');
    $req -> execute();    
    }
    
    if(isset($req)){
        $resultat =  $req ->fetchAll();
    }  else {
        $resultat = array();
    }


?>

<!-- debut de la partie contenu -->
<div class="main">
<div class="ser-main">
	<h4>Categorie <?php 
    if($categorie!="Catégorie"){
            echo $categorie; 
    }else if ($categorie=="Catégorie" && $textsearched!="tapez votre recherche"){
        echo "ALL";
    }
    else {
        header("Location: index.php");
    }
    ?></h4>
	<div class="ser-para">
	<p>Voici les résultats trouvés pour votre recherche </p>
	</div>

    <!-- debut de  ligne de 3 produits -->    
    
	<?php
	$number = 1;
	foreach ($resultat as $key => $value) {
		?>
		<div class="ser-grid-list" style="padding-left:1em;">
		<h5><?php echo $value['title']   ?></h5>
		<img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($value['image']); ?>" />
		<p> <?php  echo $value['description']; ?></p>
		<div class="btn top"><a href="annonce.php?ann=<?php echo $value['annonceId']; ?>">En savoir plus</a></div>
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