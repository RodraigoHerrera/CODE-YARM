<?php include '../../templates/sidebar.html' ?>

<?php
include '../model/conexion.php'; # llamada a la conexión

// Obtener el ID del ingrediente desde el parámetro de la URL
$id = $_GET['codigo'];

// Consulta para obtener los datos actuales del ingrediente
$sql = "SELECT * FROM ingredientes WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$ingrediente = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir los datos del formulario
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
    $cantidad_disponible = isset($_POST['cantidad_disponible']) ? $_POST['cantidad_disponible'] : 0;
    $unidad_medida = isset($_POST['unidad_medida']) ? $_POST['unidad_medida'] : '';
    $nivel_minimo = isset($_POST['nivel_minimo']) ? $_POST['nivel_minimo'] : 0;

    // Validar los datos
    if (empty($nombre) || !is_numeric($cantidad_disponible) || $cantidad_disponible < 0 || empty($unidad_medida) || !is_numeric($nivel_minimo) || $nivel_minimo < 0) {
        echo "<p class='text-center text-red-600'>Error: Por favor, ingrese todos los datos correctamente.</p>";
    } else {
        // Preparar la consulta para actualizar el ingrediente
        $sql_update = "UPDATE ingredientes SET nombre = ?, cantidad_disponible = ?, unidad_medida = ?, nivel_minimo = ? WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        if ($stmt_update) {
            $stmt_update->bind_param("sdsii", $nombre, $cantidad_disponible, $unidad_medida, $nivel_minimo, $id);
            if ($stmt_update->execute()) {
                // Redireccionar a la página de ingredientes
                header("Location: inventario.php");
                exit();
            } else {
                echo "<p class='text-center text-red-600'>Error al actualizar el ingrediente. Por favor, inténtelo de nuevo.</p>";
            }
        } else {
            echo "<p class='text-center text-red-600'>Error al preparar la consulta para actualizar el ingrediente.</p>";
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
    <title>Editar Ingrediente</title>
    <link rel="stylesheet" href="../css/styles.css"> <!-- Suponiendo que tienes un archivo CSS -->
</head>
<body>
    <div class="ml-72 mr-48 p-6">
        <h1 class="text-4xl font-bold text-center mb-8">Editar Ingrediente</h1>
        <form action="editarIngrediente.php?codigo=<?php echo $id; ?>" method="post">
            <div class="mb-4">
                <label for="nombre" class="block text-gray-700 font-bold mb-2">Nombre del Ingrediente:</label>
                <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($ingrediente['nombre']); ?>" class="w-full p-2 border rounded-md">
            </div>
            <div class="mb-4">
                <label for="cantidad_disponible" class="block text-gray-700 font-bold mb-2">Cantidad Disponible:</label>
                <input type="text" name="cantidad_disponible" id="cantidad_disponible" value="<?php echo htmlspecialchars($ingrediente['cantidad_disponible']); ?>" class="w-full p-2 border rounded-md">
            </div>
            <div class="mb-4">
                <label for="unidad_medida" class="block text-gray-700 font-bold mb-2">Unidad de Medida:</label>
                <input type="text" name="unidad_medida" id="unidad_medida" value="<?php echo htmlspecialchars($ingrediente['unidad_medida']); ?>" class="w-full p-2 border rounded-md">
            </div>
            <div class="mb-4">
                <label for="nivel_minimo" class="block text-gray-700 font-bold mb-2">Nivel Mínimo:</label>
                <input type="text" name="nivel_minimo" id="nivel_minimo" value="<?php echo htmlspecialchars($ingrediente['nivel_minimo']); ?>" class="w-full p-2 border rounded-md">
            </div>
            <div class="text-center">
                <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded-md">Guardar Cambios</button>
            </div>
        </form>
    </div>
</body>
</html>