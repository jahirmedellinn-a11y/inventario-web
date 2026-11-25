<?php
require_once 'conexion.php';

try {
    $stmt = $pdo->query("SELECT * FROM productos ORDER BY id ASC");
    $productos = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Error al consultar inventario: " . htmlspecialchars($e->getMessage()));
}

$fecha_archivo = date('Y-m-d_H-i');
$nombre_archivo = "Reporte_Inventario_{$fecha_archivo}.xls";

header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=\"{$nombre_archivo}\"");
header("Cache-Control: max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

echo "\xEF\xBB\xBF";

$total_piezas = 0;
foreach ($productos as $p) {
    $total_piezas += intval($p['cantidad']);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11pt;
        }
        .titulo {
            font-size: 15pt;
            font-weight: bold;
            text-align: center;
        }
        .subtitulo {
            font-size: 11pt;
            text-align: center;
            color: #444;
        }
        .metadatos {
            font-size: 10pt;
            margin-bottom: 12px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th {
            background-color: #F4CB92;
            color: #000000;
            font-weight: bold;
            text-align: center;
            border: 1px solid #cccccc;
            padding: 8px;
        }
        td {
            border: 1px solid #cccccc;
            padding: 6px;
            text-align: center;
        }
        .izquierda {
            text-align: left;
        }
        .total-fila {
            background-color: #eee;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <table>
        <tr>
            <td colspan="5" class="titulo">REPORTE DE INVENTARIO DE PRODUCTOS</td>
        </tr>
        <tr>
            <td colspan="5" class="subtitulo">Sistema de Inventario - Aplicaciones Web - Unidad 4</td>
        </tr>
        <tr>
            <td colspan="5" class="metadatos">
                Fecha de generación: <?php echo date('d/m/Y H:i:s'); ?> | Total de artículos: <?php echo count($productos); ?>
            </td>
        </tr>
        <tr>
            <td colspan="5"></td>
        </tr>
        <thead>
            <tr>
                <th>ID</th>
                <th>PRODUCTO</th>
                <th>CATEGORÍA</th>
                <th>DESCRIPCIÓN</th>
                <th>EXISTENCIA</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($productos) > 0): ?>
                <?php foreach ($productos as $p): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($p['id']); ?></td>
                        <td class="izquierda"><?php echo htmlspecialchars($p['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($p['categoria']); ?></td>
                        <td class="izquierda"><?php echo htmlspecialchars($p['descripcion'] ?? ''); ?></td>
                        <td><?php echo intval($p['cantidad']); ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr class="total-fila">
                    <td colspan="4" style="text-align: right;">TOTAL GENERAL DE EXISTENCIAS:</td>
                    <td><?php echo $total_piezas; ?></td>
                </tr>
            <?php else: ?>
                <tr>
                    <td colspan="5">No hay productos registrados en el sistema.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>
