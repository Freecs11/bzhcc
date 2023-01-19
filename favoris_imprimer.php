<?php
session_start();
$favs = $_SESSION['favoris']
?>
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

<body onload="setTimeout(function () {
   //Redirect with JavaScript
   window.location.href= 'favoris.php';
}, 1000);
window.print()">
    <!-- debut de la partie contenu -->
    <div class="main">
        <div class="ser-main">

            <!-- debut de  ligne de 3 produits -->
            <?php
            $number = 1;
            foreach ($favs as $key => $value) {
            ?>
                <div class="ser-grid-list">
                    <h5><?php echo $value['title'] ?></h5>
                    <img src="images/<?php echo $value['image'] ?>" alt="">
                    <p><?php echo $value['description'] ?></p>
                    
                </div>
                
            <?php  $number++;
		if($number%3==1 ){
			echo '<div class="clear"></div>';
		} }
            ?>

            <div class="sidebar">
            </div>
        </div>
        <div class="clear"></div>
    </div>
    <!-- fin de la partie contenu -->
</body>

</html>