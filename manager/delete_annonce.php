<?php
include_once("../db.php");

$id = "";
$msg="";
    // Validate id
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
    }

    // Validate id

    // Check input errors before inserting in database
    if(!empty($id)){
        // Prepare an insert statement
        $sql = 'DELETE FROM annonces WHERE annonceId='.$id;

        // Get file info 
    $pdo -> exec($sql);
            // Bind variables to the prepared statement as parameters
            // Attempt to execute the prepared statement
                // Redirect 
    header('location: list_annonces.php?msg=yes');

        
    unset($pdo);   
    }
    


?>