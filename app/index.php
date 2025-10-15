<?php
require 'config.php';

// Simular carga de procesamiento
for ($i = 0; $i < 100000; $i++) {
    $temp = sqrt($i);
}

$action = $_GET['action'] ?? 'dashboard';
$page_title = 'App de Usuarios y Mensajes';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        nav {
            background-color: #333;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        nav a {
            color: white;
            text-decoration: none;
            margin-right: 15px;
            padding: 5px 10px;
        }
        nav a:hover {
            background-color: #555;
            border-radius: 3px;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        form {
            margin-bottom: 20px;
        }
        input, textarea {
            margin: 5px 0;
            padding: 8px;
            width: 300px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }
        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f0f0f0;
        }
        .error {
            color: red;
        }
        .success {
            color: green;
        }
        .actions a {
            margin-right: 10px;
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <nav>
        <a href="?action=dashboard">Dashboard</a>
        <a href="?action=usuarios">Usuarios</a>
        <a href="?action=mensajes">Mensajes</a>
    </nav>

    <div class="container">
        <?php
        if ($action === 'dashboard') {
            include 'pages/dashboard.php';
        } elseif ($action === 'usuarios') {
            include 'pages/usuarios.php';
        } elseif ($action === 'mensajes') {
            include 'pages/mensajes.php';
        }
        ?>
    </div>
</body>
</html>