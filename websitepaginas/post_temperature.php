<?php
header('Content-Type: application/json');

// Database connectie-instellingen
$host = '49.12.77.132';
$port = '5432';
$dbname = 'sensor_data';
$user = 'runar';
$password = '3939';

// Verbind met de database
$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed."]);
    exit;
}

// Verkrijg de gegevens van de request
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Controleer of de juiste gegevens zijn ontvangen
if (!isset($data['temperature'])) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid input."]);
    exit;
}

$temperature = pg_escape_string($data['temperature']);

// Voer de insert-query uit
$query = "INSERT INTO temperature_data (temperature) VALUES ($1)";
$result = pg_query_params($conn, $query, [$temperature]);

if ($result) {
    echo json_encode(["success" => true]);
} else {
    http_response_code(500);
    echo json_encode(["error" => "Query failed."]);
}

pg_close($conn);
?>