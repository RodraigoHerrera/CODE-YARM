<?php include '../../templates/sidebar.html' ?>

<?php
include '../model/conexion.php'; # llamada a la conexión

// Consulta para obtener todos los ingredientes de la tabla ingredientes
$sql = "SELECT * FROM ingredientes ORDER BY nombre";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingredientes Disponibles</title>
    <link rel="stylesheet" href="../css/styles.css"> <!-- Suponiendo que tienes un archivo CSS -->
</head>
<body>
    <div class="ml-72 mr-48 p-6">
        <h1 class="text-4xl font-bold text-center mb-8">Inventario de Ingredientes</h1>
        <?php
            if ($result->num_rows > 0) {
                echo "<table class='min-w-full bg-white border border-gray-300 mb-6'>
                        <thead>
                            <tr>
                                <th class='py-2 px-4 border-b bg-gray-100'>Nombre</th>
                                <th class='py-2 px-4 border-b bg-gray-100'>Cantidad Disponible</th>
                                <th class='py-2 px-4 border-b bg-gray-100'>Unidad de Medida</th>
                                <th class='py-2 px-4 border-b bg-gray-100'>Nivel Mínimo</th>
                                <th class='py-2 px-4 border-b bg-gray-100'>Acción</th>
                            </tr>
                        </thead>
                        <tbody>";
                
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td class='py-4 px-4 border-b text-center'>" . htmlspecialchars($row['nombre']) . "</td>";
                    echo "<td class='py-4 px-4 border-b text-center'>" . htmlspecialchars($row['cantidad_disponible']) . "</td>";
                    echo "<td class='py-4 px-4 border-b text-center'>" . htmlspecialchars($row['unidad_medida']) . "</td>";
                    echo "<td class='py-4 px-4 border-b text-center'>" . htmlspecialchars($row['nivel_minimo']) . "</td>";
                    echo "<td class='py-4 px-4 border-b text-center'>
                             <a href='editarIngrediente.php?codigo=" . htmlspecialchars($row['id']) . "' class='bg-green-500 py-2 px-2 rounded-full text-white flex items-center justify-center w-10 h-10'>+</a>
                          </td>";
                    echo "</tr>";
                }

                echo "</tbody></table>";
            } else {
                echo "<p class='text-center text-gray-600'>No se encontraron ingredientes disponibles.</p>";
            }

            // Cerrar la conexión
            $conn->close();
        ?>
        <div class="text-center mt-8">
            <a href="agregarIngredientes.php" class="bg-green-500 text-white py-2 px-4 rounded-md">Agregar Ingrediente</a>
        </div>
    </div>
</body>
</html>

