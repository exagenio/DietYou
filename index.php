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
    DROP TABLE IF EXISTS ncds;
    CREATE TABLE users (
        id INT(11) NOT NULL AUTO_INCREMENT,
        email VARCHAR(30) NOT NULL,
        firstname VARCHAR(30) NOT NULL,
        lastname VARCHAR(30) NOT NULL,
        password CHAR(255) NOT NULL,
        weight VARCHAR(50),
        height VARCHAR(50),
        activityFactor VARCHAR(50),
        ncds VARCHAR(255),
        gender VARCHAR(10),
        age VARCHAR(10),
        allergies VARCHAR(255),
        preferences VARCHAR(255),
        country VARCHAR(255),
        planCreated BOOLEAN,
        planDate DATETIME,
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
    CREATE TABLE mealplans (
        id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        meals VARCHAR(255),
        snacks VARCHAR(255),
        user INT NOT NULL,
        estimatedWLoss FLOAT NOT NULL
    );
    
    INSERT INTO ncds (name) VALUES ('Diabetes'), ('Hyper Tension'), ('Osteoarthritis'), ('Rheumatoid Arthritis');
    INSERT INTO allergies (name, restrictions) VALUES ('lactose-intolerance', '1004,1002,1006,1008,1202,1820,1822,5802,9010,1208,1202,1204,1206,1404,1402,8008,8006,5802,5802,5804,5502,1602,1604,8006,3720,8002,4202,4204,5506,4402,5502,5504,4404,4602,3504,3602,3204,3206,3722,5806,8002,8004,5702');
    INSERT INTO allergies (name, restrictions) VALUES ('galactosemia', '1002,1004,1006,1008,1202,1204,1206,1208,1402,1602,1604,1820,1822,2608,3204,3206,3602,3702,3720,3740,4004,4202,4204,4206,4402,4404,4602,4604,4804,5202,5402,5404,5502,5504,5506,5802,5804,8002,8006,8008,9602');
    INSERT INTO allergies (name, restrictions) VALUES ('fructose-intolerance', '2604,2606,2608,2806,3104,3502,3506,3702,3703,3706,3740,4604,4804,5702,5704,6002,6016,6018,6020,6024,6414,6432,7004,7006,7102,7104,7202,7204,7206,7220,7802,8012,8802');
    SQL;

    $createTableQuery = mysqli_multi_query($connection, $createQuery);

    if (!$createTableQuery) {
        die("Error creating tables: " . mysqli_error($connection));
    }
    echo "Table created successfully";

    file_put_contents($flag_file, 'done');
    // mysqli_close($connection);
} else {
    echo "already initialized";
}





$csv_file = "foodDataSet/finalfinal.csv";
$table_name = "foods1";

// Read CSV file
$file = fopen($csv_file, "r");

// Get column headers
$headers = fgetcsv($file);

// Build SQL query to create table with column headers
$query = "CREATE TABLE foods1 (";
foreach ($headers as $header) {
    $query .= "$header VARCHAR(255),";
}
$query = rtrim($query, ","); // Remove trailing comma
$query .= ");";

print_r($headers);

$createFoods1Table = mysqli_query($connection, $query);
if (!$createFoods1Table) {
    die("query failed" . mysqli_error($connection));
};
// Create SQL statement
$sql = "INSERT INTO $table_name (" . implode(",", $headers) . ") VALUES ";

// Loop through data rows
while (($data = fgetcsv($file)) !== FALSE) {
    // Escape data values
    $escaped_data = array_map(array($conn, 'real_escape_string'), $data);

    // Add row to SQL statement
    $sql .= "('" . implode("','", $escaped_data) . "'),";
}

// Remove last comma from SQL statement
$sql = rtrim($sql, ",");



// Execute SQL statement
if ($conn->query($sql) === TRUE) {
    echo "CSV data imported successfully";
} else {
    echo "Error importing CSV data: " . $conn->error;
}

//Close connection and file
$conn->close();
fclose($file);
