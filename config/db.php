<?php
// Datos de conexión
$bdName = "streaming";
$dsn = "mysql:host=localhost;dbname=$bdName;charset=utf8mb4";
$user = "root";
$password = "";


try {
    // Crear conexión usando PDO
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage());
}
