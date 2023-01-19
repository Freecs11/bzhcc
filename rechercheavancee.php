<?php
session_start();
include("inc/top.php");


?>
<!-- debut de la partie contenu -->
<div class="main">
    <div class="ser-main">
        <!-- a form to search for a specific product by its name and category 
    and by a min-max trench 
    styled vertically -->
        <div class="col span_2_of_4">
            <div class="contact-form">
                <h3>Recherche avancée</h3>
                <form action="search.php" method="post">
                    <div>
                        <span><label>Nom de l'annonce</label></span>
                        <span><input name="titre" type="text" class="textbox" required></span>
                    </div>
                    <div>
                        <span><label>Catégorie</label></span>
                        <span>
                            <select class="custom-select" id="select-1" name="selection">
                                <?php
                                foreach ($_SESSION['categories'] as $key => $value) {
                                ?>
                                    <option value="<?php echo $value[0]; ?>"><?php echo $value[0]; ?></option>
                                <?php }
                                ?>
                            </select>
                        </span>
                    </div>
                    <!--  add a min-max trench  -->
                    <div>
                        <span><label>Prix</label></span>
                        <span>
                            <input type="number" name="min" placeholder="min" required>
                            <input type="number" name="max" placeholder="max" required>
                        </span>

                    </div>

                    <div>
                        <span><input type="submit" value="Submit"></span>
                    </div>
                </form>

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
                    <?php    }
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