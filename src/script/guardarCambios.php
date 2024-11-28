<?php
include '../model/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir los datos del formulario
    $producto_id = isset($_POST['producto_id']) ? intval($_POST['producto_id']) : null;
    $ingrediente_ids = isset($_POST['ingrediente_ids']) ? $_POST['ingrediente_ids'] : [];
    $cantidades = isset($_POST['cantidades']) ? $_POST['cantidades'] : [];
    $ingredientes = isset($_POST['ingredientes']) ? $_POST['ingredientes'] : [];
    $nuevos_ingredientes = isset($_POST['nuevos_ingredientes']) ? $_POST['nuevos_ingredientes'] : [];
    $nuevas_cantidades = isset($_POST['nuevas_cantidades']) ? $_POST['nuevas_cantidades'] : [];

    if ($producto_id === null) {
        echo "<p class='text-center text-red-600'>Error: No se especificó un ID de producto válido.</p>";
        exit();
    }

    // Validar los datos recibidos
    $valido = true;
    foreach ($cantidades as $cantidad) {
        if (!is_numeric($cantidad) || $cantidad <= 0) {
            $valido = false;
            break;
        }
    }
    foreach ($nuevas_cantidades as $cantidad) {
        if (!is_numeric($cantidad) || $cantidad <= 0) {
            $valido = false;
            break;
        }
    }

    if (!$valido) {
        echo "<p class='text-center text-red-600'>Error: Todas las cantidades deben ser números positivos.</p>";
        echo "<a href='javascript:history.back()' class='text-blue-500'>Volver</a>";
        exit();
    }

    // Realizar la actualización de cada ingrediente en la base de datos
    for ($i = 0; $i < count($ingrediente_ids); $i++) {
        $ingrediente_id = intval($ingrediente_ids[$i]);
        $cantidad = floatval($cantidades[$i]);
        $ingrediente_nombre = $ingredientes[$i];

        // Preparar la consulta para actualizar la tabla recetas
        $sql_recetas = "UPDATE recetas SET cantidad = ? WHERE producto_id = ? AND ingrediente_id = ?";
        $stmt_recetas = $conn->prepare($sql_recetas);
        if ($stmt_recetas) {
            $stmt_recetas->bind_param("dii", $cantidad, $producto_id, $ingrediente_id);
            if (!$stmt_recetas->execute()) {
                echo "<p class='text-center text-red-600'>Error al actualizar la cantidad del ingrediente ID: $ingrediente_id. Por favor, inténtelo de nuevo.</p>";
            }
        } else {
            echo "<p class='text-center text-red-600'>Error al preparar la consulta para actualizar la base de datos (recetas).</p>";
            exit();
        }

        // Preparar la consulta para actualizar la tabla ingredientes
        $sql_ingredientes = "UPDATE ingredientes SET nombre = ? WHERE id = ?";
        $stmt_ingredientes = $conn->prepare($sql_ingredientes);
        if ($stmt_ingredientes) {
            $stmt_ingredientes->bind_param("si", $ingrediente_nombre, $ingrediente_id);
            if (!$stmt_ingredientes->execute()) {
                echo "<p class='text-center text-red-600'>Error al actualizar el nombre del ingrediente ID: $ingrediente_id. Por favor, inténtelo de nuevo.</p>";
            }
        } else {
            echo "<p class='text-center text-red-600'>Error al preparar la consulta para actualizar la base de datos (ingredientes).</p>";
            exit();
        }
    }

    // Insertar nuevos ingredientes en la base de datos
    for ($i = 0; $i < count($nuevos_ingredientes); $i++) {
        $nuevo_ingrediente_id = intval($nuevos_ingredientes[$i]);
        $nueva_cantidad = floatval($nuevas_cantidades[$i]);

        // Verificar que el ingrediente no esté duplicado
        $sql_check = "SELECT * FROM recetas WHERE ingrediente_id = ? AND producto_id = ?";
        $stmt_check = $conn->prepare($sql_check);
        if ($stmt_check) {
            $stmt_check->bind_param("ii", $nuevo_ingrediente_id, $producto_id);
            $stmt_check->execute();
            $result_check = $stmt_check->get_result();
            if ($result_check->num_rows > 0) {
                // Ingrediente ya existe, no insertar
                continue;
            }
        }

        // Insertar el nuevo ingrediente en la tabla recetas
        $sql_insert = "INSERT INTO recetas (producto_id, ingrediente_id, cantidad) VALUES (?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        if ($stmt_insert) {
            $stmt_insert->bind_param("iid", $producto_id, $nuevo_ingrediente_id, $nueva_cantidad);
            if (!$stmt_insert->execute()) {
                echo "<p class='text-center text-red-600'>Error al insertar el nuevo ingrediente ID: $nuevo_ingrediente_id. Por favor, inténtelo de nuevo.</p>";
            }
        } else {
            echo "<p class='text-center text-red-600'>Error al preparar la consulta para insertar el nuevo ingrediente en la base de datos.</p>";
            exit();
        }
    }

    // Cerrar la conexión
    $conn->close();

    // Redireccionar a la página de recetas
    header("Location: ../views/recetas.php");
    exit();
} else {
    echo "<p class='text-center text-red-600'>Solicitud inválida.</p>";
    exit();
}
?>
