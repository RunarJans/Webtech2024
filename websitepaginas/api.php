<?php
header("Content-Type: application/json");

// PostgreSQL connection parameters
$host = "localhost";
$port = "5432";
$dbname = "sensor_data";
$user = "runar";
$password = "3939";

// Connect to PostgreSQL
$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    die(json_encode(["error" => "Connection failed: " . pg_last_error()]));
}

$request_method = $_SERVER["REQUEST_METHOD"];
switch($request_method) {
    case 'GET':
        if (isset($_GET["get"]) && $_GET["get"] === "latest") {
            get_latest_temperatures();
        } elseif (!empty($_GET["id"])) {
            $id = intval($_GET["id"]);
            get_temperature($id);
        } else {
            get_temperatures();
        }
        break;
    case 'POST':
        insert_temperature();
        break;
    case 'PUT':
        if (!empty($_GET["id"])) {
            $id = intval($_GET["id"]);
            update_temperature($id);
        } else {
            echo json_encode(["error" => "ID is missing for update"]);
        }
        break;
    case 'DELETE':
        if (!empty($_GET["id"])) {
            $id = intval($_GET["id"]);
            delete_temperature($id);
        } else {
            reset_temperatures(); // Call a function to delete all records
        }
        break;
    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

function get_temperatures() {
    global $conn;
    $result = pg_query($conn, "SELECT * FROM temperature_data ORDER BY timestamp DESC");
    if (!$result) {
        http_response_code(500);
        echo json_encode(["error" => "Query failed."]);
    } else {
        $data = pg_fetch_all($result);
        echo json_encode($data);
    }
}

function get_temperature($id) {
    global $conn;
    $result = pg_query_params($conn, "SELECT * FROM temperature_data WHERE id = $1", array($id));
    if (!$result) {
        http_response_code(500);
        echo json_encode(["error" => "Query failed."]);
    } else {
        $data = pg_fetch_assoc($result);
        echo json_encode($data);
    }
}

function get_latest_temperatures() {
    global $conn;
    $result = pg_query($conn, "SELECT * FROM temperature_data ORDER BY timestamp DESC LIMIT 20");
    if (!$result) {
        http_response_code(500);
        echo json_encode(["error" => "Query failed."]);
    } else {
        $data = pg_fetch_all($result);
        // Ensure the timestamp is in the correct format for JavaScript
        foreach ($data as &$row) {
            $row['timestamp'] = date('c', strtotime($row['timestamp']));
        }
        echo json_encode($data);
    }
}

function insert_temperature() {
    global $conn;
    $data = json_decode(file_get_contents('php://input'), true);
    $temperature = $data['temperature'];
    $result = pg_query_params($conn, "INSERT INTO temperature_data (temperature) VALUES ($1)", array($temperature));
    if ($result) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["error" => pg_last_error()]);
    }
}

function update_temperature($id) {
    global $conn;
    $data = json_decode(file_get_contents('php://input'), true);
    $temperature = $data['temperature'];
    $result = pg_query_params($conn, "UPDATE temperature_data SET temperature = $1 WHERE id = $2", array($temperature, $id));
    if ($result) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["error" => pg_last_error()]);
    }
}

function delete_temperature($id) {
    global $conn;
    $result = pg_query_params($conn, "DELETE FROM temperature_data WHERE id = $1", array($id));
    if ($result) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["error" => pg_last_error()]);
    }
}

function reset_temperatures() {
    global $conn;
    $result = pg_query($conn, "DELETE FROM temperature_data");
    if ($result) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["error" => pg_last_error()]);
    }
}
?>