<?php
session_start();
include("inc/top.php");
require_once "db.php";


// Define variables and initialize with empty values
$mail = $password = $confirm_password = $nom = $prenom = "";
$mail_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

	// Validate username
	if (empty(trim($_POST["mail"]))) {
		$mail_err = "Please enter a mail.";
	} elseif (!preg_match('/^[a-zA-Z0-9_@]+$/', trim($_POST["mail"]))) {
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
echo '<p>SUCEESSSSSS</p>';
?>