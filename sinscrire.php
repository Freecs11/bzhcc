<?php
session_start();
include("inc/top.php");
require_once "db.php";


// Define variables and initialize with empty values
$mail = $password = $confirm_password = $nom = $prenom = "";
$mail_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$pattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i";
	// Validate username
	if (empty(trim($_POST["mail"]))) {
		$mail_err = "Please enter a mail.";
	} elseif (!preg_match($pattern, trim($_POST["mail"]))) {
		$mail_err = "mail can only contain letters, numbers, and underscores.";
	} else {
		// Prepare a select statement
		$sql = "SELECT id FROM users WHERE mail = :username";

		if ($stmt = $pdo->prepare($sql)) {
			// Bind variables to the prepared statement as parameters
			$stmt->bindParam(":username", $param_username, PDO::PARAM_STR);

			// Set parameters
			$param_username = trim($_POST["mail"]);

			// Attempt to execute the prepared statement
			if ($stmt->execute()) {
				if ($stmt->rowCount() == 1) {
					$mail_err = "This mail is already taken.";
				} else {
					$mail = trim($_POST["mail"]);
					$nom = trim($_POST["nom"]);
					$prenom = trim($_POST["prenom"]);
				}
			} else {
				echo "Oops! Something went wrong. Please try again later.";
			}

			// Close statement
			unset($stmt);
		}
	}

	// Validate password
	if (empty(trim($_POST["password"]))) {
		$password_err = "Please enter a password.";
	} elseif (strlen(trim($_POST["password"])) < 6) {
		$password_err = "Password must have atleast 6 characters.";
	} else {
		$password = trim($_POST["password"]);
	}

	// Validate confirm password
	if (empty(trim($_POST["confirm_password"]))) {
		$confirm_password_err = "Please confirm password.";
	} else {
		$confirm_password = trim($_POST["confirm_password"]);
		if (empty($password_err) && ($password != $confirm_password)) {
			$confirm_password_err = "Password did not match.";
		}
	}

	// Check input errors before inserting in database
	if (empty($mail_err) && empty($password_err) && empty($confirm_password_err)) {

		// Prepare an insert statement
		$sql = "INSERT INTO users (nom , prenom,mail, password) VALUES (:nom , :prenom , :mail , :password)";

		if ($stmt = $pdo->prepare($sql)) {
			// Bind variables to the prepared statement as parameters
			$stmt->bindParam(":mail", $param_mail, PDO::PARAM_STR);
			$stmt->bindParam(":nom", $param_nom, PDO::PARAM_STR);
			$stmt->bindParam(":prenom", $param_prenom, PDO::PARAM_STR);
			$stmt->bindParam(":password", $param_password, PDO::PARAM_STR);

			// Set parameters
			$param_mail = $mail;
			$param_nom = $nom;
			$param_prenom = $prenom;
			$param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

			// Attempt to execute the prepared statement
			if ($stmt->execute()) {
				// Redirect to login page
				header("location: login.php");
			} else {
				echo "Oops! Something went wrong. Please try again later.";
			}

			// Close statement
			unset($stmt);
		}
	}

	// Close connection
	unset($pdo);
}
?>

<!-- debut de la partie contenu -->
<div class="main">
	<div class="register">
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			<div class="register-top-grid">
				<h3>Vos informations</h3>
				<div>
					<span>Prénom<label>*</label></span>
					<input type="text" name="prenom">
				</div>
				<div>
					<span>Nom<label>*</label></span>
					<input type="text" name="nom">
				</div>
				<div>
					<span>Email<label>*</label></span>
					<input type="text" name="mail" class="form-control <?php echo (!empty($mail_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $mail; ?>">
					<span class="invalid-feedback"><?php echo $mail_err; ?></span>
				</div>
				<div class="clear"> </div>
				<a class="news-letter" href="#">
					<label class="checkbox"><input type="checkbox" name="checkbox" checked=""><i> </i>S'inscrire à la neswletter</label>
				</a>
			</div>
			<div class="register-bottom-grid">
				<h3>Pour vous authentifier</h3>
				<div>
					<span>Password<label>*</label></span>
					<input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
					<span class="invalid-feedback"><?php echo $password_err; ?></span>
				</div>
				<div>
					<span>Retapez votre Password<label>*</label></span>
					<input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
					<span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
				</div>
				<div class="clear"> </div>
			</div>
			<div class="clear"> </div>
			<div class="register-but">
				<input type="submit" class="btn btn-primary" value="Submit">
				<div class="clear"> </div>
		</form>

	</div>
</div>
<div class="clear"></div>
</div>
<!-- fin de la partie contenu -->

<?php
include("inc/bottom.php");
?>