<?php
require_once 'conexion.php';

$id = $_GET['id'] ?? ($_POST['id'] ?? null);

if (!$id || !is_numeric($id)) {
    header('Location: productos.php?error=no_encontrado');
    exit;
}

$id = intval($id);

try {
    $stmt = $pdo->prepare("DELETE FROM productos WHERE id = ?");
    $stmt->execute([$id]);

    header('Location: productos.php?msg=eliminado');
    exit;
} catch (PDOException $e) {
    header('Location: productos.php?error=error_eliminar');
    exit;
}
?>