<?php include '../../templates/sidebar.html' ?>

<?php
include '../model/conexion.php';
// ID del producto correspondiente a la Pizza Margherita
$sql = "SELECT productos.nombre AS producto, ingredientes.nombre AS ingrediente, recetas.cantidad, ingredientes.unidad_medida, productos.id  AS lol, recetas.id AS lol1 
        FROM recetas
        INNER JOIN productos ON recetas.producto_id = productos.id
        INNER JOIN ingredientes ON recetas.ingrediente_id = ingredientes.id
        ORDER BY productos.nombre";

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
    <div class=" ml-72 mr-48 p-6">
        <h1 class="text-4xl font-bold text-center mb-8">Recetas de Productos</h1>
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
                        echo "<div class='mb-8 '>";
                        echo "<div class= 'flex items-center mb-4'>
                            <h2 class='text-2xl font-semibold text-purple-800 pr-5'>$producto_actual</h2>
                            <a href='modIngrediente.php?codigo=".htmlspecialchars($row['lol']) ."' class='bg-yellow-300 py-2 px-4 rounded-md'>Editar</a>
                        </div>";

                        echo "<table class=' min-w-full bg-white border border-gray-300 mb-6 '>
                                <thead>
                                    <tr>
                                        <th class='py-2 px-4 border-b bg-gray-100'>Ingrediente</th>
                                        <th class='py-2 px-4 border-b bg-gray-100'>Cantidad</th>
                                        <th class='py-2 px-4 border-b bg-gray-100'>Unid.</th>
                                        <th class='py-2 px-4 border-b bg-gray-100'>Opcion</th>
                                    </tr>
                                </thead>
                                <tbody>";
                    }

                    // Mostrar cada ingrediente dentro de la tabla del producto correspondiente
                    echo "<tr>";
                    echo "<td class='py-4 px-4 border-b text-center'>" . htmlspecialchars($row['ingrediente']) . "</td>";
                    echo "<td class='py-4 px-4 border-b text-center'>" . htmlspecialchars($row['cantidad']) . "</td>";
                    echo "<td class='py-4 px-4 border-b text-center'>" . htmlspecialchars($row['unidad_medida']) . "</td>";
                    echo "<td class='py-4 px-4 border-b text-center'><a href='../script/eliminar.php?codigo=".htmlspecialchars($row['lol1']) ."' class='bg-red-600 text-white py-2 px-4 rounded-md'>Eliminar</a></td>";
                    echo "</tr>";
                }

                // Cerrar la última tabla
                echo "</tbody></table></div>";
            } 
            else {
                echo "<p class='text-center text-gray-600'>No se encontraron recetas.</p>";
            }

        // Cerrar conexión
        $conn->close();
        ?>
    </div>
</body>
</html>

