<?php
include_once("../db.php");
include("inc/top.php");

$name = "";
$msg="";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    if (isset($_POST["name"])) {
        $name = $_POST["name"];
    }
    // Validate id

    // Check input errors before inserting in database
    if(isset($name)){
        // Prepare an insert statement
        $sql = 'INSERT INTO categories (NAME) VALUES (:name)';
        // Get file info 

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":name", $param_name, PDO::PARAM_STR);
            
            // Set parameters      
           $param_name = $name;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to login page
                $msg = 'SUCCESSFULLY Added ' .$name . ' !';
            } else {
                $msg = "Oops! Something went wrong. Please try again later.";
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
        <h1 class="mt-4">Catégories</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Catégories</li>
        </ol>
        <div class="card mb-4">
            <div class="card-body">
                <?php
                if (!empty($msg)) {
                    echo $msg;
                } else {
                    echo 'Message de l\'action';
                }
                ?>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Ajouter une catégorie
            </div>
            <div class="card-body">
                <table>
                    <thead>
                        <tr>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
                                <th>Nom </th>
                                <th><input type="text" name="name" value="" /> </th>
                                <th><input type="submit" name="" value="Ajouter cette catégorie" /></th>
                            </form>
                        </tr>
                    </thead>


                </table>
            </div>
        </div>
    </div>
</main>

<!-- fin contenu -->


<?php
include("inc/bottom.php");
?>