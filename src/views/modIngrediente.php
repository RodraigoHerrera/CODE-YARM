<?php include '../../templates/sidebar.html' ?>

<?php
include '../model/conexion.php';

// ID del producto que deseas mostrar desde la URL
$producto_id = $_GET["codigo"]; // Obtener el ID del producto desde el parametro 'codigo'

// Consulta modificada para obtener solo un producto especifico
$sql = "SELECT productos.nombre AS producto, ingredientes.nombre AS ingrediente, recetas.cantidad, ingredientes.unidad_medida, recetas.id AS lol 
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receta del Producto Específico</title>
</head>
<body>
    <div class=" ml-72 mr-48 p-6">
        <h1 class="text-4xl font-bold text-center mb-8">Receta del Producto</h1>
        <form action="guardarCambios.php" method="post">
        <?php
            if ($result->num_rows > 0) {
                $producto_actual = "";

                while ($row = $result->fetch_assoc()) 
                {
                    // Verificar si el producto ha cambiado para crear una nueva sección de producto
                    if ($producto_actual !== $row['producto']) {
                        if ($producto_actual !== "") {
                            // Cerrar el <table> anterior cuando cambie de producto
                            echo "</tbody></table></div>";
                        }

                        // Actualizar el producto actual y crear un nuevo título y tabla
                        $producto_actual = $row['producto'];
                        echo "<div class='mb-8'>";
                        echo "<h2 class='text-2xl font-semibold text-purple-800 mb-4'>$producto_actual</h2>";

                        echo "<table class=' min-w-full bg-white border border-gray-300 mb-6 '>
                                <thead>
                                    <tr>
                                        <th class='py-2 px-4 border-b bg-gray-100'>Ingrediente</th>
                                        <th class='py-2 px-4 border-b bg-gray-100'>Cantidad</th>
                                        <th class='py-2 px-4 border-b bg-gray-100'>Unid.</th>
                                    </tr>
                                </thead>
                                <tbody>";
                    }

                    // Mostrar cada ingrediente como input editable dentro de la tabla del producto correspondiente
                    echo "<tr>";
                    echo "<td class='py-4 px-4 border-b text-center'><input type='text' name='ingredientes[]' value='" . htmlspecialchars($row['ingrediente']) . "' class='w-full text-center border rounded-md'></td>";
                    echo "<td class='py-4 px-4 border-b text-center'><input type='text' name='cantidades[]' value='" . htmlspecialchars($row['cantidad']) . "' class='w-full text-center border rounded-md'></td>";
                    echo "<td class='py-4 px-4 border-b text-center'><input type='text' name='unidades[]' value='" . htmlspecialchars($row['unidad_medida']) . "' class='w-full text-center border rounded-md'></td>";
                    echo "</tr>";
                }

                // Cerrar la última tabla
                echo "</tbody></table></div>";
                echo "<div class='text-center mt-4'><button type='button' class='bg-green-500 text-white py-2 px-4 rounded-md'>Confirmar</button></div>";
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
