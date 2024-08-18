<?php
header('Content-Type: application/json');

$host = '49.12.77.132';
$port = '5432';
$dbname = 'sensor_data';
$user = 'runar';
$password = 'also a secret';

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed."]);
    exit;
}

$result = pg_query($conn, "SELECT * FROM temperature_data");
if (!$result) {
    http_response_code(500);
    echo json_encode(["error" => "Query failed."]);
    exit;
}

$data = pg_fetch_all($result);

echo json_encode($data);
pg_close($conn);
?>