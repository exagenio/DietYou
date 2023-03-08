<?php
$connection = mysqli_connect("localhost", "root", "root", "dietYou");
$flag_file = 'flag.txt';
if (!file_exists($flag_file)) {
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }
    //create users table
    $createQuery = <<<SQL
    DROP TABLE IF EXISTS users;
    DROP TABLE IF EXISTS allergies;
    CREATE TABLE users (
        id INT(11) NOT NULL AUTO_INCREMENT,
        email VARCHAR(30) NOT NULL,
        firstname VARCHAR(30) NOT NULL,
        lastname VARCHAR(30) NOT NULL,
        password CHAR(255) NOT NULL,
        weight VARCHAR(50),
        height VARCHAR(50),
        ncds VARCHAR(255),
        gender VARCHAR(10),
        age VARCHAR(10),
        allergies VARCHAR(255),
        preferences VARCHAR(255),
        cuisine VARCHAR(255),
        PRIMARY KEY (id)
    );
    
    CREATE TABLE allergies (
        id INT(11) NOT NULL AUTO_INCREMENT,
        name VARCHAR(255) NOT NULL,
        restrictions VARCHAR(255),
        PRIMARY KEY (id)
    );
    CREATE TABLE ncds (
        id INT(11) NOT NULL AUTO_INCREMENT,
        name VARCHAR(255) NOT NULL,
        PRIMARY KEY (id)
    );
    INSERT INTO ncds (name) VALUES ('Diabetes'), ('Hyper Tension'), ('Osteoarthritis'), ('Rheumatoid Arthritis');
    SQL;
    
    $createTableQuery = mysqli_multi_query($connection, $createQuery);
    
    if (!$createTableQuery) {
        die("Error creating tables: " . mysqli_error($connection));
    }
    echo "Table created successfully";
    // Create the flag file
    file_put_contents($flag_file, 'done');
    mysqli_close($connection);
}else{
    echo "already initialized";
}
?>