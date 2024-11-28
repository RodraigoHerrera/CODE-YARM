<?php
include '../model/conexion.php'; # llamada a la conexión

// Obtener el ID del producto desde el parámetro de la URL
$id = $_GET['codigo'];

// Consulta para obtener los datos actuales del producto
$sql = "SELECT * FROM productos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$producto = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir los datos del formulario
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
    $precio_venta = isset($_POST['precio_venta']) ? $_POST['precio_venta'] : 0;
    $estado = isset($_POST['estado']) ? $_POST['estado'] : '';

    // Validar los datos
    if (empty($nombre) || !is_numeric($precio_venta) || $precio_venta < 0 || empty($estado)) {
        echo "<p class='text-center text-red-600'>Error: Por favor, ingrese todos los datos correctamente.</p>";
    } else {
        // Preparar la consulta para actualizar el producto
        $sql_update = "UPDATE productos SET nombre = ?, precio_venta = ?, estado = ? WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        if ($stmt_update) {
            $stmt_update->bind_param("sdsi", $nombre, $precio_venta, $estado, $id);
            if ($stmt_update->execute()) {
                // Redireccionar a la página de gestión de productos
                header("Location: menu.php");
                exit();
            } else {
                echo "<p class='text-center text-red-600'>Error al actualizar el producto. Por favor, inténtelo de nuevo.</p>";
            }
        } else {
            echo "<p class='text-center text-red-600'>Error al preparar la consulta para actualizar el producto.</p>";
        }
    }

    // Cerrar la conexión
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> <!-- Tailwind CSS -->
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <h1 class="text-4xl font-bold text-center mb-8 text-gray-800">Modificar Producto</h1>
        <form action="editarProducto.php?codigo=<?php echo $id; ?>" method="post" class="bg-white p-6 rounded-lg shadow-md">
            <div class="mb-4">
                <label for="nombre" class="block text-gray-700 font-bold mb-2">Nombre del Producto:</label>
                <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>" class="w-full p-2 border rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="precio_venta" class="block text-gray-700 font-bold mb-2">Precio de Venta:</label>
                <input type="text" name="precio_venta" id="precio_venta" value="<?php echo htmlspecialchars($producto['precio_venta']); ?>" class="w-full p-2 border rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="estado" class="block text-gray-700 font-bold mb-2">Estado:</label>
                <select name="estado" id="estado" class="w-full p-2 border rounded-md">
                    <option value="activo" <?php echo $producto['estado'] == 'activo' ? 'selected' : ''; ?>>Activo</option>
                    <option value="desactivo" <?php echo $producto['estado'] == 'desactivo' ? 'selected' : ''; ?>>Desactivo</option>
                </select>
            </div>
            <div class="text-center">
                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md">Guardar Cambios</button>
            </div>
        </form>
    </div>
</body>
</html>
