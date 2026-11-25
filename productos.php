<?php
require_once 'conexion.php';

$mensaje = '';
$tipo_alerta = 'exito';

if (isset($_GET['msg'])) {
    if ($_GET['msg'] === 'agregado') {
        $mensaje = 'Producto registrado correctamente.';
    } elseif ($_GET['msg'] === 'modificado') {
        $mensaje = 'Producto modificado correctamente.';
    } elseif ($_GET['msg'] === 'eliminado') {
        $mensaje = 'Producto eliminado correctamente.';
    }
} elseif (isset($_GET['error'])) {
    $tipo_alerta = 'error';
    if ($_GET['error'] === 'no_encontrado') {
        $mensaje = 'El producto no fue encontrado.';
    } else {
        $mensaje = 'Ocurrió un error al procesar la solicitud.';
    }
}

try {
    $stmt = $pdo->query("SELECT * FROM productos ORDER BY id ASC");
    $productos = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Error al consultar productos: " . htmlspecialchars($e->getMessage()));
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Productos</title>
    <link rel="stylesheet" href="style.css?v=2">
</head>

<body>

    <header>
        <h1>Inventario de Productos</h1>
    </header>

    <nav>
        <a href="index.php">Inicio</a>
        <a href="productos.php">Productos</a>
        <a href="agregar.php">Agregar Producto</a>
    </nav>

    <main>

        <?php if (!empty($mensaje)): ?>
            <div class="alerta alerta-<?php echo $tipo_alerta; ?>">
                <?php echo htmlspecialchars($mensaje); ?>
            </div>
        <?php endif; ?>

        <div style="text-align: right; margin-bottom: 10px;">
            <a href="exportar_excel.php" class="btn-exportar">Exportar a Excel</a>
        </div>

        <table>
            <tr>
                <th>ID</th>
                <th>Producto</th>
                <th>Categoría</th>
                <th>Descripción</th>
                <th>Existencia</th>
                <th>Acciones</th>
            </tr>

            <?php if (count($productos) > 0): ?>
                <?php foreach ($productos as $prod): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($prod['id']); ?></td>
                        <td><?php echo htmlspecialchars($prod['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($prod['categoria']); ?></td>
                        <td><?php echo htmlspecialchars($prod['descripcion'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($prod['cantidad']); ?></td>
                        <td style="white-space: nowrap;">
                            <a href="editar.php?id=<?php echo $prod['id']; ?>" class="btn-modificar">Modificar</a>
                            <a href="eliminar.php?id=<?php echo $prod['id']; ?>" class="btn-eliminar" onclick="return confirm('¿Está seguro de eliminar este producto?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No hay productos registrados en el inventario.</td>
                </tr>
            <?php endif; ?>

        </table>

    </main>

    <footer>
        Aplicaciones Web - Unidad 4
    </footer>
    <br>
    <img src="img/without.png" alt="Logo UTSAN JUAN" class="footer-img">

</body>

</html>
