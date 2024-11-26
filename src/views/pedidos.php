<?php include '../../templates/sidebar.html' ?>

<?php
include '../model/conexion.php';
// Consulta SQL para obtener todos los pedidos y sus detalles
$sql = "SELECT pedidos.id AS pedido_id, usuarios.nombre AS cliente, pedidos.fecha_entrega, 
               pedidos.direccion_entrega, pedidos.total, pedidos.instrucciones_especiales,
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
    
</body>
</html>