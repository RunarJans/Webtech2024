<?php
header('Content-Type: application/json');

$host = '49.12.77.132';
$port = '5432';
$dbname = 'sensor_data';
$user = 'runar';
$password = 'a secret';

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed."]);
    exit;
}

// Lees de JSON data van de aanvraag
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!isset($data['id'])) {
    http_response_code(400);
    echo json_encode(["error" => "ID parameter is missing."]);
    exit;
}

$id = $data['id'];

$result = pg_query_params($conn, "DELETE FROM temperature_data WHERE id = $1", array($id));

if (!$result) {
    http_response_code(500);
    echo json_encode(["error" => "Query failed."]);
} else {
    echo json_encode(["success" => true]);
}

pg_close($conn);
?>