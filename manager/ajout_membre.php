<?php
include_once("../db.php");
include("inc/top.php");

$name =$pass =$mail=$prenom= "";
$msg="";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    if (isset($_POST["name"])) {
        $name = $_POST["name"];
    }
    if (isset($_POST["prenom"])) {
        $prenom = $_POST["prenom"];
    }
    if (isset($_POST["mail"])) {
        $mail = $_POST["mail"];
    }
    if (isset($_POST["password"])) {
        $pass =  password_hash($_POST["password"], PASSWORD_DEFAULT); 
    }
    // Validate id

    // Check input errors before inserting in database
    if(isset($name) && isset($prenom) && isset($mail) && isset($pass)){
        // Prepare an insert statement
        $sql = 'INSERT INTO users (nom,prenom,mail,password) VALUES (:name,:prenom,:mail,:password)';
        // Get file info 

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":name", $param_name, PDO::PARAM_STR);
            $stmt->bindParam(":prenom", $param_prenom, PDO::PARAM_STR);
            $stmt->bindParam(":mail", $param_mail, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            
            // Set parameters      
           $param_name = $name;
           $param_prenom = $prenom;
           $param_mail = $mail;
           $param_password = $pass;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to login page
                $msg = 'SUCCESSFULLY Added ' .$name . ' !';
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
                Ajouter un membre
            </div>
            <div class="card-body">
                <table>
                <thead>
                        <tr>
                                <th>Nom</th>
                                <th>Prenom</th>
                                <th>Mail </th>
                                <th>Password</th>
                                
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
                                <td><input type="text" name="name" value="" /> </td>
                                <td><input type="text" name="prenom" value="" /> </td>
                                <td><input type="text" name="mail" value="" /> </td>
                                <td><input type="text" name="password" value="" /> </td>
                                <td><input type="submit" name="" value="Ajouter" /></td>
                            </form>
                        </tr>
                    </tbody>


                </table>
            </div>
        </div>
    </div>
</main>

<!-- fin contenu -->


<?php
include("inc/bottom.php");
?>