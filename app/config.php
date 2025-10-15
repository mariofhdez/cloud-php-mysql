<?php
// Conexión a MySQL usando variables de entorno
$host = $_ENV['MYSQL_HOST'] ?? 'mysql-svc';
$user = $_ENV['MYSQL_USER'] ?? 'app_user';
$pass = $_ENV['MYSQL_PASSWORD'] ?? 'app_password';
$db = $_ENV['MYSQL_DB'] ?? 'app_db';
$port = 3306;

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Sin prepared statements - vulnerable y lento
// Sin connection pooling
// Sin caching

// mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conn->set_charset("utf8mb4");