<?php
// Initialize the session
session_start();
 
// Unset all of the session variables
unset($_SESSION['loggedin']);
unset($_SESSION['id']);
unset($_SESSION['nom']);
if(isset($_SESSION['adminin'])){
    unset($_SESSION['adminin']);
}

 
// Redirect to login page
header("location: index.php");
exit;
?>