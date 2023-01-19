<?php
include_once("../db.php");
include("inc/top.php");

$name = $id = "";
$msg="";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    if (isset($_POST["name"])) {
        $name = $_POST["name"];
    }
    // Validate id
    if (isset($_POST["id"])) {
        $id = $_POST["id"];
    }

    // Check input errors before inserting in database
    if(isset($name) && isset($id)){
        // Prepare an insert statement
        $sql = 'UPDATE categories SET NAME=:name WHERE id=:id';
        // Get file info 


        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":name", $param_name, PDO::PARAM_STR);
            $stmt->bindParam(":id", $param_id, PDO::PARAM_STR);
            
            // Set parameters
            $param_id = $id;
            $param_name = $name;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to login page
                $msg = 'SUCCESSFULLY Updated !';
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



<!--  debut contenu -->
<main>

    <div class="container-fluid px-4">
        <div class="card mb-4"></div>

        <div class="card mb-4">
            <div class="card-body">
                <?php 
                if(!empty($msg)){
                    echo $msg;
                }else{
                    echo 'Message de l\'action' ;
                }
                ?>
            </div>
        </div>
        <div class="card mb-4">

        </div>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Catégories
            </div>
            <div class="card-body">
               
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" >
                                <input name="id" type="hidden" value="<?php 
                                if(isset($_GET['id'])) {
                                    echo $_GET['id'] ;
                                }else {
                                    echo 'none';
                                } ?>">
                                <input name="name" type="text" class="textbox">
                                <input type="submit" value="Submit">
                        </form>
                
            </div>
        </div>
    </div>
</main>

<!-- fin contenu -->


<?php
include("inc/bottom.php");
?>