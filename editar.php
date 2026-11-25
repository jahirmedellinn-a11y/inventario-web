<?php
require_once 'conexion.php';

$error = '';
$id = $_GET['id'] ?? ($_POST['id'] ?? null);

if (!$id || !is_numeric($id)) {
    header('Location: productos.php?error=no_encontrado');
    exit;
}

$id = intval($id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre      = trim($_POST['nombre'] ?? '');
    $categoria   = trim($_POST['categoria'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $cantidad    = trim($_POST['cantidad'] ?? '');

    if (empty($nombre) || empty($categoria) || $cantidad === '') {
        $error = 'Por favor complete todos los campos obligatorios.';
    } elseif (!is_numeric($cantidad) || intval($cantidad) < 0) {
        $error = 'La cantidad debe ser un número mayor o igual a cero.';
    } else {
        try {
            $stmt = $pdo->prepare("UPDATE productos SET nombre = ?, categoria = ?, descripcion = ?, cantidad = ? WHERE id = ?");
            $stmt->execute([$nombre, $categoria, $descripcion, intval($cantidad), $id]);

            header('Location: productos.php?msg=modificado');
            exit;
        } catch (PDOException $e) {
            $error = 'Error al actualizar el producto: ' . $e->getMessage();
        }
    }
} else {
    try {
        $stmt = $pdo->prepare("SELECT * FROM productos WHERE id = ?");
        $stmt->execute([$id]);
        $producto = $stmt->fetch();

        if (!$producto) {
            header('Location: productos.php?error=no_encontrado');
            exit;
        }

        $nombre      = $producto['nombre'];
        $categoria   = $producto['categoria'];
        $descripcion = $producto['descripcion'];
        $cantidad    = $producto['cantidad'];
    } catch (PDOException $e) {
        die("Error al consultar producto: " . htmlspecialchars($e->getMessage()));
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Modificar Producto</title>
    <link rel="stylesheet" href="style.css?v=2">
</head>

<body>

    <header>
        <h1>Modificar Producto</h1>
    </header>

    <nav>
        <a href="index.php">Inicio</a>
        <a href="productos.php">Productos</a>
        <a href="agregar.php">Agregar Producto</a>
    </nav>

    <main>

        <?php if (!empty($error)): ?>
            <div class="alerta alerta-error">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form action="editar.php?id=<?php echo $id; ?>" method="POST">

            <input type="hidden" name="id" value="<?php echo $id; ?>">

            <label>Nombre del producto</label>
            <input type="text" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>

            <label>Categoría</label>
            <input type="text" name="categoria" value="<?php echo htmlspecialchars($categoria); ?>" required>

            <label>Descripción</label>
            <textarea name="descripcion" rows="4"><?php echo htmlspecialchars($descripcion); ?></textarea>

            <label>Cantidad</label>
            <input type="number" name="cantidad" value="<?php echo htmlspecialchars($cantidad); ?>" required>

            <button type="submit">
                Guardar Cambios
            </button>

        </form>

    </main>

    <footer>
        Aplicaciones Web - Unidad 4
    </footer>
    <br>
    <img src="img/without.png" alt="Logo UTSAN JUAN" class="footer-img">

</body>

</html>
