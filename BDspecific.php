<?php
    // this is just for the bd specific stuff , trying to keep it out of the main file and it's in localhost 
    // final db connection is put in Amazon AWS RDS 
    // this is the localhost db
    session_start();

    $server="localhost";
    $login="root";
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        $pass = "";
    } else {
        $pass="root";
    }
    $dbexists = false;
    function checkDBexists() {
        global $dbexists;
        global $pass;
       try{
        $conn = new PDO("mysql:host=localhost", "root", $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        //Now since I have been connected, I want to check DB existence.
        $databases = $conn->query('show databases')->fetchAll(PDO::FETCH_COLUMN);
    
        if(in_array("pw",$databases))
        {
            
            echo "db exists already";
        }
        else {
            $req = $conn-> prepare("CREATE DATABASE pw");
            $req -> execute();
            
            echo "db created now <br>";
        }
        $dbexists=true;
        $conn =null;
    }
    catch(PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
    }
} 
    checkDBexists();
    if ($dbexists){
        try{
		$conn = new PDO("mysql:host=$server;dbname=pw",$login,$pass);
		$conn -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $req = $conn-> prepare("
        CREATE TABLE IF NOT EXISTS categories (
            id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
            NAME varchar(100) NOT NULL
            );

        CREATE TABLE IF NOT EXISTS users (
            id int NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            nom varchar(25) NOT NULL,
            prenom varchar(25) NOT NULL,
            mail varchar(100) NOT NULL,
            password VARCHAR(255) NOT NULL,
            createdat datetime DEFAULT current_timestamp(),
            admin BOOLEAN NOT NULL
            );         

        CREATE TABLE IF NOT EXISTS annonces (
            annonceId int NOT NULL AUTO_INCREMENT PRIMARY KEY,
            title varchar(150) NOT NULL,
            price double NOT NULL,
            image longblob ,
            description varchar(1000) ,
            categorie int,
            createdat datetime DEFAULT current_timestamp(),
            userId int ,
            FOREIGN KEY (categorie) REFERENCES categories(id),
            FOREIGN KEY (userId) REFERENCES users(id)
          );        
          
        CREATE TABLE IF NOT EXISTS favs (
            id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
            annonId INT NOT NULL,
            userId INT NOT NULL,
            FOREIGN KEY (annonId) REFERENCES annonces(annonceId),
            FOREIGN KEY (userId) REFERENCES users(id)
        );

        CREATE TABLE IF NOT EXISTS contact (
            id int NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            nom varchar(20) NOT NULL,
            email varchar(20) NOT NULL,
            telephone VARCHAR(255) NOT NULL,
            msg VARCHAR(700) NOT NULL
            );   
    ");
		$req -> execute();   
        $req -> closeCursor();
        $req2 = $conn -> prepare("
        INSERT INTO categories (id, NAME) VALUES
        (1, 'Jouet'),
        (2, 'Jeux'),
        (3, 'Livres'),
        (4, 'Bijoux'),
        (5, 'Voitures'),
        (6, 'Locations');
        ");
        $req2 -> execute();
		echo "\n tables created and data added ";
		
		}
	catch(PDOException $e){
		echo 'Erreur '.$e->getMessage();
	}
    }else{
        checkDBexists();
    }

    echo "\n";