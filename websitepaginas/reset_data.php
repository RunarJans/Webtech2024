<?php
header('Content-Type: application/json');


// PostgreSQL connection parameters
$host = "49.12.77.132";
$port = "5432";
$dbname = "sensor_data";
$user = "runar";
$password = "a secret";

// Connect to PostgreSQL
$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    echo json_encode(["success" => false, "message" => "Connection failed: " . pg_last_error()]);
    exit();
}

// Reset the table
$query = "TRUNCATE TABLE temperature_data RESTART IDENTITY";
$result = pg_query($conn, $query);

if ($result) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Error truncating table: " . pg_last_error()]);
}

pg_close($conn);
?>