<?php
$connection = mysqli_connect("localhost", "root", "root", "dietYou");
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

$tableName = "users";
$dropTable = "DROP TABLE IF EXISTS $tableName";
$dropTableQuery = mysqli_query($connection, $dropTable);
if (!$dropTableQuery) {
    die("Error dropping table: " . mysqli_error($connection));
}

$createQuery = <<<SQL
CREATE TABLE $tableName (
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
)
SQL;

$createTableQuery = mysqli_query($connection, $createQuery);

if (!$createTableQuery) {
    die("Error creating table: " . mysqli_error($connection));
}

echo "Table created successfully";
mysqli_close($connection);
?>