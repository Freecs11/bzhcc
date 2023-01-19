<?php
session_start();
include("inc/top.php");
require_once "db.php";

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["mail"]))){
        $username_err = "Please enter email.";
    } else{
        $mail = trim($_POST["mail"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id,nom,prenom, mail, password ,isadmin FROM users WHERE mail = :mail";
        
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":mail", $param_username, PDO::PARAM_STR);
            
            // Set parameters
            $param_username = trim($_POST["mail"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Check if username exists, if yes then verify password
                if($stmt->rowCount() == 1){
                    if($row = $stmt->fetch()){
                        $id = $row["id"];
                        $mail = $row["mail"];
						$name = $row["nom"];
						$prenom = $row["prenom"];
                        $hashed_password = $row["password"];
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["nom"] = $name; 
							$_SESSION["prenom"]= $prenom;
                            if($row['isadmin']== 1 ){
                                $_SESSION['adminin']=true;
                            }
                            
                            // Redirect user to welcome page
                            header("location: index.php");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }
    unset($pdo);
	}

?>

<!-- debut de la partie contenu -->
<div class="main">

		<div class="register">
			   <div class="col_1_of_list span_1_of_list login-left">
			  	 <h3>Nouveau membre</h3>
				 <p>En créant un compte, vous pourrez créer des annonces</p>
				 <a class="acount-btn" href="sinscrire.php">Créer un compte</a>
			   </div>
			   <div class="col_1_of_list span_1_of_list login-right">
			  	<h3>Déja membre ?</h3>
				<p>Si vous avez déja un compte, merci de vous connecter</p>
				<?php 
				if(!empty($login_err)){
					echo '<div class="alert alert-danger">' . $login_err . '</div>';
				}        
				?>
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
				  <div>
					<span>Adresse email<label>*</label></span>
					<input type="text" name="mail"> 
				  </div>
				  <div>
					<span>Mot de passe<label>*</label></span>
					<input type="password" name ="password"> 
				  </div>
				  <a class="forgot" href="#">Mot de passe oublié</a>
				  <input type="submit" value="Login">
			    </form>
			   </div>	
			   <div class="clearfix"> </div>
		
	</div>
  <div class="clear"></div>
</div><!-- fin de la partie contenu -->

<?php
include("inc/bottom.php");
?>