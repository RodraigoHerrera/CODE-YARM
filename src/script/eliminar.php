<?php
include '../model/conexion.php'; # llamada a la conexión

$id = $_GET['codigo']; # guardar en variable el dato que obtenga de 'codigo'

$sentencia = $conn->prepare("DELETE FROM recetas WHERE id = ?;");
$resultado = $sentencia->execute([$id]);

if ($resultado) {
    // Redireccionar a la página de recetas
    header("Location: ../views/recetas.php");
    exit();
} else {
    echo "<p class='text-center text-red-600'>Error al eliminar el ingrediente de la receta. Por favor, inténtelo de nuevo.</p>";
}
?>
