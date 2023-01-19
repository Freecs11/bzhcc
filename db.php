<?php 

 

$server = "localhost";
$login = "root";
$pass = "root";

 
/* Attempt to connect to MySQL database */
try{
    $pdo = new PDO("mysql:host=" . $server . ";dbname=pw" , $login, $pass);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("Could not connect. " . $e->getMessage());
}
function getCategorieId($cat){
    global $pdo;
    $requete = $pdo-> prepare('SELECT id FROM categories WHERE NAME="'.$cat.'"');
    $requete -> execute();
    return $requete ->fetch()[0];
}
function getCategorieName($cat){
    global $pdo;
    $requete = $pdo-> prepare('SELECT NAME FROM categories WHERE id="'.$cat.'"');
    $requete -> execute();
    return $requete ->fetch()[0];
}
    

?>
