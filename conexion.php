<?php
/**
 * Conexión a la base de datos MySQL usando PDO
 * Sistema de Inventario - Aplicaciones Web
 */

$host     = 'localhost';
$dbname   = 'inventario_db';
$usuario  = 'root';
$password = '';
$charset  = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

$opciones = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $usuario, $password, $opciones);
} catch (PDOException $e) {
    die("<h3>Error al conectar con la base de datos:</h3> " . htmlspecialchars($e->getMessage()));
}
?>