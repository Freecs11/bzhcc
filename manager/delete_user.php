<?php
include_once("../db.php");

$id = "";
$msg="";
    // Validate id
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
    }
    $req = $pdo->prepare("SELECT * FROM annonces WHERE userId=$id");
    $req->execute();
    $allAnn = $req->fetchAll();
    $req->closeCursor();

    foreach ($allAnn as $key => $value) {
        $req =$pdo -> prepare('UPDATE annonces SET userId=0');
        $req -> execute();
        $req -> closeCursor();
    }
    // Validate id

    // Check input errors before inserting in database
    if(!empty($id)){
        // Prepare an insert statement
        $sql = 'DELETE FROM users WHERE id='.$id;

        // Get file info 
    $pdo -> exec($sql);
            // Bind variables to the prepared statement as parameters
            // Attempt to execute the prepared statement
                // Redirect 
    header('location: list_membres.php?msg=yes');

        
    unset($pdo);   
    }
    


?>