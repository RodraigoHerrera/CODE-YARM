
<?php
$servername = "localhost";
$username = "root"; // Usuario por defecto en XAMPP
$password = "Assurance1234.";     // Contraseña por defecto es vacía en XAMPP
$dbname = "sistemaweb"; // Cambia esto al nombre de tu base de datos

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
// if ($conn->connect_error) {
//     die("Conexión fallida: " . $conn->connect_error);
// } else {
//     echo "Conexión exitosa a la base de datos";
// }
?>
