<?php include '../../templates/sidebar.html' ?>

<?php
include '../model/conexion.php';

// ID del producto que deseas mostrar desde la URL
$producto_id = $_GET["codigo"]; // Obtener el ID del producto desde el parametro 'codigo'

// Consulta modificada para obtener solo un producto especifico
$sql = "SELECT productos.nombre AS producto, ingredientes.nombre AS ingrediente, recetas.cantidad, ingredientes.unidad_medida, recetas.id AS receta_id, ingredientes.id AS ingrediente_id
        FROM recetas
        INNER JOIN productos ON recetas.producto_id = productos.id
        INNER JOIN ingredientes ON recetas.ingrediente_id = ingredientes.id
        WHERE productos.id = ?
        ORDER BY productos.nombre";

// Preparar la consulta para evitar inyecciones SQL
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $producto_id);
$stmt->execute();
$result = $stmt->get_result();

// Obtener todos los ingredientes disponibles
$sql_ingredientes = "SELECT id, nombre FROM ingredientes";
$result_ingredientes = $conn->query($sql_ingredientes);
$ingredientes_disponibles = [];
if ($result_ingredientes->num_rows > 0) {
    while ($row = $result_ingredientes->fetch_assoc()) {
        $ingredientes_disponibles[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receta del Producto Específico</title>
    <script>
        function agregarFila() {
            const tabla = document.getElementById('tabla-ingredientes');
            const nuevaFila = document.createElement('tr');

            nuevaFila.innerHTML = `
                <td class='py-4 px-4 border-b text-center'>
                    <select name='nuevos_ingredientes[]' class='w-full text-center border rounded-md'>
                        <option value='' disabled selected>Seleccione un ingrediente</option>
                        <?php foreach ($ingredientes_disponibles as $ingrediente): ?>
                            <option value='<?php echo $ingrediente['id']; ?>'><?php echo $ingrediente['nombre']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td class='py-4 px-4 border-b text-center'><input type='text' name='nuevas_cantidades[]' class='w-full text-center border rounded-md'></td>
                <td class='py-4 px-4 border-b text-center'>Unidad</td>
            `;

            tabla.appendChild(nuevaFila);
        }
    </script>
</head>
<body>
    <div class=" ml-72 mr-48 p-6">
        <h1 class="text-4xl font-bold text-center mb-8">Receta del Producto</h1>
        <form action="../script/guardarCambios.php" method="post">
            <input type="hidden" name="producto_id" value="<?php echo $producto_id; ?>">
            <?php
                if ($result->num_rows > 0) {
                    $producto_actual = "";

                    echo "<div class='mb-8'>";
                    echo "<h2 class='text-2xl font-semibold text-purple-800 mb-4'>$producto_actual</h2>";
                    echo "<table id='tabla-ingredientes' class='min-w-full bg-white border border-gray-300 mb-6'>
                            <thead>
                                <tr>
                                    <th class='py-2 px-4 border-b bg-gray-100'>Ingrediente</th>
                                    <th class='py-2 px-4 border-b bg-gray-100'>Cantidad</th>
                                    <th class='py-2 px-4 border-b bg-gray-100'>Unid.</th>
                                </tr>
                            </thead>
                            <tbody>";

                    while ($row = $result->fetch_assoc()) 
                    {
                        echo "<tr>";
                        echo "<td class='py-4 px-4 border-b text-center'><input type='hidden' name='ingrediente_ids[]' value='" . htmlspecialchars($row['ingrediente_id']) . "'><input type='text' name='ingredientes[]' value='" . htmlspecialchars($row['ingrediente']) . "' class='w-full text-center border rounded-md'></td>";
                        echo "<td class='py-4 px-4 border-b text-center'><input type='text' name='cantidades[]' value='" . htmlspecialchars($row['cantidad']) . "' class='w-full text-center border rounded-md'></td>";
                        echo "<td class='py-4 px-4 border-b text-center'>" . htmlspecialchars($row['unidad_medida']) . "</td>";
                        echo "</tr>";
                    }

                    // Cerrar la última tabla
                    echo "</tbody></table></div>";
                    echo "<div class='text-center mt-4'>
                            <button type='button' onclick='agregarFila()' class='bg-green-500 text-white py-2 px-4 rounded-md'>+</button>
                            <button type='submit' class='bg-green-500 text-white py-2 px-4 rounded-md'>Confirmar</button>
                            </div>";
                } 
                else {
                    echo "<p class='text-center text-gray-600'>No se encontraron recetas para el producto especificado.</p>";
                }

                // Cerrar conexión
                $conn->close();
            ?>
        </form>
    </div>
</body>
</html>
