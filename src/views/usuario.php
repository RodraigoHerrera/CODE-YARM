<?php include '../../templates/navbarUsuario.html' ?>

<?php
include '../model/conexion.php'; # llamada a la conexión

// Consulta para obtener todos los productos que están activos
$sql = "SELECT * FROM productos WHERE estado = 'activo' ORDER BY nombre";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos Disponibles</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> <!-- Tailwind CSS -->
</head>
<body class="bg-gray-100 pt-20">
    <div class="container mx-auto p-6 ">
        <h1 class="text-4xl font-bold text-center mb-8 text-gray-800">MENÚ DE LA SEMANA </h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow'>";
                        echo "<img class='w-full h-48 object-cover rounded-t-lg' src='../images/" . htmlspecialchars($row['id']) . ".jpg' alt='Imagen de " . htmlspecialchars($row['nombre']) . "'>"; # Suponiendo que el nombre de la imagen coincide con el ID del producto
                        echo "<div class='flex'>";
                        echo "<div class='p-6 basis-0 flex-grow'>";
                        echo "<h2 class='text-2xl font-semibold text-gray-800 mb-2'>" . htmlspecialchars($row['nombre']) . "</h2>";
                        echo "<p class='text-lg text-green-600 font-bold'>Bs.- " . htmlspecialchars($row['precio_venta']) . "</p>";
                        echo "</div>";
                        echo "<div class='flex items-center mr-5'>";
                        echo "<button type='submit' class='bg-green-600 text-white  rounded-full  hover:bg-blue-600 w-10 h-10'>+</button>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<p class='text-center text-gray-600'>No se encontraron productos disponibles.</p>";
                }

                // Cerrar la conexión
                $conn->close();
            ?>
        </div>
    </div>
</body>
</html>
