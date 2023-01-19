<?php
session_start();
require_once "db.php";
    $favs = $_SESSION['favoris'];
    $myId = $_SESSION['id'];

    //remove all previous favs 
    $req = $pdo->prepare('SELECT * FROM favs WHERE userId=' . $myId);
    $req->execute();
    $res = $req -> fetchAll();
    $req->closeCursor();
    if(!empty($res)){
    $req = $pdo->prepare('DELETE  FROM favs WHERE userId=' . $myId);
    $req->execute();
    $req->closeCursor();
    }
    // Prepare an insert statement
    

    foreach ($favs as $key => $value) {
        $sql = "INSERT INTO favs (annonId,userId) VALUES (:annonId , :userId)";
        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":annonId", $param_annonId, PDO::PARAM_STR);
            $stmt->bindParam(":userId", $param_userId, PDO::PARAM_STR);
            // Set parameters
            $param_annonId = $value['annonceId'];
            $param_userId = $myId;

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
        unset($sql);
}
header('location: index.php');
?>