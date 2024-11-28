<?php include '../../templates/sidebar.html' ?>

<?php
include '../model/conexion.php';
// Consulta SQL para obtener todos los pedidos y sus detalles
$sql = "SELECT pedidos.id AS pedido_id, usuarios.nombre AS cliente, pedidos.fecha_entrega AS fecha, 
               pedidos.direccion_entrega AS direccion, pedidos.total AS total, pedidos.instrucciones_especiales,
               productos.nombre AS producto, detalle_pedidos.cantidad
        FROM pedidos
        INNER JOIN usuarios ON pedidos.usuario_id = usuarios.id
        INNER JOIN detalle_pedidos ON pedidos.id = detalle_pedidos.pedido_id
        INNER JOIN productos ON detalle_pedidos.producto_id = productos.id
        ORDER BY pedidos.fecha_entrega DESC, pedidos.id";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="ml-72 mr-48 p-6">
        <h1 class="text-4xl font-bold text-center mb-8">Pedidos</h1>
        <?php
            if ($result->num_rows > 0) {
                echo "<table class='min-w-full bg-white border border-gray-300 mb-6'>
                        <thead>
                            <tr>
                                <th class='py-2 px-4 border-b bg-gray-100'>Cliente</th>
                                <th class='py-2 px-4 border-b bg-gray-100'>Fecha de entrega</th>
                                <th class='py-2 px-4 border-b bg-gray-100'>Dirección</th>
                                <th class='py-2 px-4 border-b bg-gray-100'>Total</th>
                                <th class='py-2 px-4 border-b bg-gray-100'>Producto</th>
                            </tr>
                        </thead>
                        <tbody>";
                
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td class='py-4 px-4 border-b text-center'>" . htmlspecialchars($row['cliente']) . "</td>";
                    echo "<td class='py-4 px-4 border-b text-center'>" . htmlspecialchars($row['fecha']) . "</td>";
                    echo "<td class='py-4 px-4 border-b text-center'>" . htmlspecialchars($row['direccion']) . "</td>";
                    echo "<td class='py-4 px-4 border-b text-center'>" . htmlspecialchars($row['total']) . "</td>";
                    echo "<td class='py-4 px-4 border-b text-center'>" . htmlspecialchars($row['producto']) . "</td>";
                    echo "</tr>";
                }

                echo "</tbody></table>";
            } else {
                echo "<p class='text-center text-gray-600'>No se encontraron ingredientes disponibles.</p>";
            }

            // Cerrar la conexión
            $conn->close();
        ?>
    </div>
</body>
</html>