<?php
require_once("db.php");
session_start();
include("inc/top.php");

// Define variables and initialize with empty values
$desc = $title = $price = $categorie = "";
$desc_err = $title_err = $price_err = $categorie_err = "";
// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate description
    if (empty($_POST["description"])) {
        $desc_err = "Please enter a description";
    } else {
        $desc = $_POST["description"];
    }
    // Validate title
    if (empty($_POST["title"])) {
        $title_err = "Please enter a title.";
    } else {
        $title = $_POST["title"];
    }
    // Validate confirm price
    if (empty($_POST["cate"])) {
        $categorie_err = "Please Select a Categorie.";
    } else {
        $categorie = $_POST["cate"];
    }

    // Validate confirm price
    if (empty($_POST["price"])) {
        $price_err = "Please Enter a Price.";
    } else {
        $price = $_POST["price"];
    }
    

    // Check input errors before inserting in database
    if (empty($desc_err) && empty($title_err) && empty($price_err)) {

        $image = file_get_contents($_FILES['image']['tmp_name']);

        // Prepare an insert statement
        $sql = 'INSERT INTO annonces (title , price,image,description, categorie ,userId) VALUES (:title , :price , :image ,:descr, :categorie , :uid )';

        // Get file info 


        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":descr", $param_desc, PDO::PARAM_STR);
            $stmt->bindParam(":price", $param_price, PDO::PARAM_STR);
            $stmt->bindParam(":categorie", $param_categorie, PDO::PARAM_STR);
            $stmt->bindParam(":title", $param_title, PDO::PARAM_STR);
            $stmt->bindParam(":image", $param_image, PDO::PARAM_STR);
            $stmt->bindParam(":uid", $param_uid, PDO::PARAM_STR);


          
            
            // Set parameters
            $param_image = $image;
            $param_uid = $_SESSION['id'];
            $param_desc = $desc;
            $param_price = $price;
            $param_categorie = $categorie;
            $param_title = $title; // Creates a title hash


            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to login page
                header("location: index.php");
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
     unset($pdo);   
    }
    
}

?>

<!-- debut de la partie contenu -->
<div class="main">
    <div class="section group">
        <div class="col span_2_of_4">
            <div class="contact-form">
                <h3>Ajouter une annonce : </h3>
                <?php
                if (!empty($login_err)) {
                    echo '<div class="alert alert-danger">' . $title_err . $price_err . $categorie_err . $desc_err  .  '</div>';
                }
                ?>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                    <div>
                        <span><label>Titre</label></span>
                        <span><input name="title" type="text" class="textbox"></span>
                    </div>
                    <div>
                        <span><label>Price</label></span>
                        <span><input name="price" type="number" class="textbox"></span>
                    </div>
                    <div>
                        <span><label>Description</label></span>
                        <span><textarea name="description"> </textarea></span>
                    </div>
                    <div>
                        <span><label>Catégorie</label></span>
                        <select class="custom-select" id="select-1" name="cate">
                            <?php
                            foreach ($_SESSION['categories'] as $key => $value) {
                            ?>
                                <option value="<?php echo getCategorieId($value[0]); ?>"><?php echo $value[0]; ?></option>
                            <?php }
                            ?>
                        </select>
                    </div>
                    <div>
                        <span><label>Select Image File:</label></span>
                        <input type="file" name="image">
                    </div>
                    <div>
                        <span><input type="submit" value="Submit"></span>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <div class="clear"></div>
</div>
<!-- fin de la partie contenu -->

<?php
include("inc/bottom.php");
?>