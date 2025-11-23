<?php

$host = "localhost";
$user = "root";
$pass = "";
$db   = "projeto"; 

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    http_response_code(500);
    die(json_encode(['error' => 'Falha na conexão: ' . $conn->connect_error]));
}
$conn->set_charset('utf8mb4');
?>