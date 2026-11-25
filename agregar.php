<?php
require_once 'conexion.php';

$error = '';
$nombre = '';
$categoria = '';
$descripcion = '';
$cantidad = '';

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
            $stmt = $pdo->prepare("INSERT INTO productos (nombre, categoria, descripcion, cantidad) VALUES (?, ?, ?, ?)");
            $stmt->execute([$nombre, $categoria, $descripcion, intval($cantidad)]);

            header('Location: productos.php?msg=agregado');
            exit;
        } catch (PDOException $e) {
            $error = 'Error al registrar el producto: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Agregar Producto</title>
    <link rel="stylesheet" href="style.css?v=2">
</head>

<body>

    <header>
        <h1>Registro de Producto</h1>
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

        <form action="agregar.php" method="POST">

            <label>Nombre del producto</label>
            <input type="text" name="nombre" placeholder="Ingrese nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>

            <label>Categoría</label>
            <input type="text" name="categoria" placeholder="Ingrese categoría" value="<?php echo htmlspecialchars($categoria); ?>" required>

            <label>Descripción</label>
            <textarea name="descripcion" rows="4"><?php echo htmlspecialchars($descripcion); ?></textarea>

            <label>Cantidad</label>
            <input type="number" name="cantidad" placeholder="0" value="<?php echo htmlspecialchars($cantidad); ?>" required>

            <button type="submit">
                Guardar Producto
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
