<?php include '../../templates/sidebar.html' ?>

<?php
include '../model/conexion.php'; # llamada a la conexión

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
    $cantidad_disponible = isset($_POST['cantidad_disponible']) ? $_POST['cantidad_disponible'] : 0;
    $unidad_medida = isset($_POST['unidad_medida']) ? $_POST['unidad_medida'] : '';
    $nivel_minimo = isset($_POST['nivel_minimo']) ? $_POST['nivel_minimo'] : 0;

    // Validar los datos
    if (empty($nombre) || !is_numeric($cantidad_disponible) || $cantidad_disponible < 0 || empty($unidad_medida) || !is_numeric($nivel_minimo) || $nivel_minimo < 0) {
        echo "<p class='text-center text-red-600'>Error: Por favor, ingrese todos los datos correctamente.</p>";
    } else {
        // Preparar la consulta para insertar el nuevo ingrediente
        $sql = "INSERT INTO ingredientes (nombre, cantidad_disponible, unidad_medida, nivel_minimo) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("sdsi", $nombre, $cantidad_disponible, $unidad_medida, $nivel_minimo);
            if ($stmt->execute()) {
                // Redireccionar a la página de ingredientes
                header("Location: inventario.php");
                exit();
            } else {
                echo "<p class='text-center text-red-600'>Error al agregar el ingrediente. Por favor, inténtelo de nuevo.</p>";
            }
        } else {
            echo "<p class='text-center text-red-600'>Error al preparar la consulta para insertar el ingrediente.</p>";
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
    <title>Agregar Ingrediente</title>
    <link rel="stylesheet" href="../css/styles.css"> <!-- Suponiendo que tienes un archivo CSS -->
</head>
<body>
    <div class="ml-72 mr-48 p-6">
        <h1 class="text-4xl font-bold text-center mb-8">Agregar Nuevo Ingrediente</h1>
        <form action="agregarIngredientes.php" method="post">
            <div class="mb-4">
                <label for="nombre" class="block text-gray-700 font-bold mb-2">Nombre del Ingrediente:</label>
                <input type="text" name="nombre" id="nombre" class="w-full p-2 border rounded-md">
            </div>
            <div class="mb-4">
                <label for="cantidad_disponible" class="block text-gray-700 font-bold mb-2">Cantidad Disponible:</label>
                <input type="text" name="cantidad_disponible" id="cantidad_disponible" class="w-full p-2 border rounded-md">
            </div>
            <div class="mb-4">
                <label for="unidad_medida" class="block text-gray-700 font-bold mb-2">Unidad de Medida:</label>
                <input type="text" name="unidad_medida" id="unidad_medida" class="w-full p-2 border rounded-md">
            </div>
            <div class="mb-4">
                <label for="nivel_minimo" class="block text-gray-700 font-bold mb-2">Nivel Mínimo:</label>
                <input type="text" name="nivel_minimo" id="nivel_minimo" class="w-full p-2 border rounded-md">
            </div>
            <div class="text-center">
                <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded-md">Agregar Ingrediente</button>
            </div>
        </form>
    </div>
</body>
</html>
