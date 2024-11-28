<?php include '../../templates/sidebar.html' ?>

<?php
include '../model/conexion.php'; # llamada a la conexión

// Actualizar el estado del producto si se recibe una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['producto_id']) && isset($_POST['nuevo_estado'])) {
        $producto_id = intval($_POST['producto_id']);
        $nuevo_estado = $_POST['nuevo_estado'];
        $sql_update = "UPDATE productos SET estado = ? WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("si", $nuevo_estado, $producto_id);
        $stmt_update->execute();
    } elseif (isset($_POST['nombre']) && isset($_POST['precio_venta']) && isset($_POST['estado']) && isset($_POST['producto_id_modificar'])) {
        // Modificar producto existente
        $producto_id = intval($_POST['producto_id_modificar']);
        $nombre = $_POST['nombre'];
        $precio_venta = $_POST['precio_venta'];
        $estado = $_POST['estado'];
        $sql_update_producto = "UPDATE productos SET nombre = ?, precio_venta = ?, estado = ? WHERE id = ?";
        $stmt_update_producto = $conn->prepare($sql_update_producto);
        $stmt_update_producto->bind_param("sdsi", $nombre, $precio_venta, $estado, $producto_id);
        $stmt_update_producto->execute();
    } elseif (isset($_POST['nombre']) && isset($_POST['precio_venta']) && isset($_POST['estado'])) {
        // Insertar nuevo producto
        $nombre = $_POST['nombre'];
        $precio_venta = $_POST['precio_venta'];
        $estado = $_POST['estado'];
        $sql_insert = "INSERT INTO productos (nombre, precio_venta, estado) VALUES (?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("sds", $nombre, $precio_venta, $estado);
        $stmt_insert->execute();
    } elseif (isset($_POST['eliminar_producto_id'])) {
        // Eliminar producto
        $producto_id = intval($_POST['eliminar_producto_id']);
        $sql_delete = "DELETE FROM productos WHERE id = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bind_param("i", $producto_id);
        $stmt_delete->execute();
    }
}

// Consulta para obtener todos los productos
$sql = "SELECT * FROM productos ORDER BY nombre";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> <!-- Tailwind CSS -->
</head>
<body class="bg-gray-100">
    <div class="ml-72 p-6 overflow-x-hidden w-[calc(100%-18rem)]">
        <h1 class="text-4xl font-bold text-center mb-8 text-gray-800">Gestión de Productos</h1>
        <div class="overflow-x-auto w-full">
            <table class="min-w-full bg-white rounded-lg shadow-md">
                <thead>
                    <tr>
                        <th class="py-3 px-6 bg-gray-200 text-left text-xs font-bold text-gray-700 uppercase">Nombre</th>
                        <th class="py-3 px-6 bg-gray-200 text-left text-xs font-bold text-gray-700 uppercase">Precio Venta</th>
                        <th class="py-3 px-6 bg-gray-200 text-left text-xs font-bold text-gray-700 uppercase">Estado</th>
                        <th class="py-3 px-6 bg-gray-200 text-left text-xs font-bold text-gray-700 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr class='border-b'>";
                            echo "<td class='py-4 px-6 text-gray-800'>" . htmlspecialchars($row['nombre']) . "</td>";
                            echo "<td class='py-4 px-6 text-gray-800'>$" . htmlspecialchars($row['precio_venta']) . "</td>";
                            echo "<td class='py-4 px-6 text-gray-800'>" . htmlspecialchars($row['estado']) . "</td>";
                            echo "<td class='py-4 px-6 text-gray-800'>";
                            echo "<form action='' method='POST' class='inline-block'>";
                            echo "<input type='hidden' name='producto_id' value='" . htmlspecialchars($row['id']) . "'>";
                            $nuevo_estado = $row['estado'] === 'activo' ? 'desactivo' : 'activo';
                            echo "<button type='submit' name='nuevo_estado' value='$nuevo_estado' class='bg-blue-500 text-white py-1 px-4 rounded-md mr-2'>Cambiar a $nuevo_estado</button>";
                            echo "</form>";
                            echo "<a href='editarProducto.php?codigo=" . htmlspecialchars($row['id']) . "' class='bg-yellow-500 text-white py-1 px-4 rounded-md mr-2'>Modificar</a>";
                            echo "<form action='' method='POST' class='inline-block'>";
                            echo "<input type='hidden' name='eliminar_producto_id' value='" . htmlspecialchars($row['id']) . "'>";
                            echo "<button type='submit' class='bg-red-500 text-white py-1 px-4 rounded-md'>Eliminar</button>";
                            echo "</form>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' class='py-4 px-6 text-center text-gray-600'>No se encontraron productos.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="mt-10">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Agregar Nuevo Producto</h2>
            <form action="" method="POST" class="bg-white p-6 rounded-lg shadow-md">
                <div class="mb-4">
                    <label for="nombre" class="block text-gray-700 font-bold mb-2">Nombre del Producto:</label>
                    <input type="text" name="nombre" id="nombre" class="w-full p-2 border rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="precio_venta" class="block text-gray-700 font-bold mb-2">Precio de Venta:</label>
                    <input type="text" name="precio_venta" id="precio_venta" class="w-full p-2 border rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="estado" class="block text-gray-700 font-bold mb-2">Estado:</label>
                    <select name="estado" id="estado" class="w-full p-2 border rounded-md">
                        <option value="activo">Activo</option>
                        <option value="desactivo">Desactivo</option>
                    </select>
                </div>
                <div class="text-center">
                    <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded-md">Agregar Producto</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

