<?php
session_start(); // Inicia la sesión para registrar intentos fallidos

// Configuración del sistema de bloqueo
$maxIntentos = 5; // Máximo de intentos permitidos
$tiempoBloqueo = 300; // Tiempo de bloqueo en segundos (5 minutos)

// Inicializar variables de sesión
if (!isset($_SESSION['intentos_fallidos'])) {
    $_SESSION['intentos_fallidos'] = 0;
}

if (!isset($_SESSION['bloqueado_hasta'])) {
    $_SESSION['bloqueado_hasta'] = 0;
}

// Verificar si el usuario está bloqueado
if (time() < $_SESSION['bloqueado_hasta']) {
    $tiempoRestante = ($_SESSION['bloqueado_hasta'] - time());
    $error_message = "Acceso bloqueado. Inténtalo después de " . gmdate("i:s", $tiempoRestante) . " minutos.";
    include '../views/login.php';
    exit();
}

// Conexión a la base de datos
include '../model/conexion.php';

// Obtener datos del formulario
$correo = trim($_POST['correo']);
$contrasena = trim($_POST['contrasena']);
$error_message = '';

// Buscar usuario en la base de datos
$sql = "SELECT * FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();

    // Verificar la contraseña
    if (password_verify($contrasena, $usuario['contraseña'])) {
        // Reiniciar los intentos fallidos si la autenticación es exitosa
        $_SESSION['intentos_fallidos'] = 0;
        $_SESSION['bloqueado_hasta'] = 0;

        // Guardar ID del usuario en la sesión
        $_SESSION['usuario_id'] = $usuario['id'];

        // Decidir a qué página redirigir
        if ($correo == 'ana.gomez@example.com') { // Reemplaza con el correo del administrador
            header('Location: ../views/admin.php');
        } else {
            header('Location: ../views/usuario.php');
        }
        exit();
    } else {
        // Incrementar intentos fallidos
        $_SESSION['intentos_fallidos']++;

        if ($_SESSION['intentos_fallidos'] >= $maxIntentos) {
            $_SESSION['bloqueado_hasta'] = time() + $tiempoBloqueo;
            $error_message = "Demasiados intentos fallidos. Acceso bloqueado por 5 minutos.";
            include '../views/login.php'; // Incluye el HTML con el mensaje de error
            exit();
        } else {
            $intentosRestantes = $maxIntentos - $_SESSION['intentos_fallidos'];
            $error_message = "Contraseña incorrecta. Intentos restantes: $intentosRestantes";
            include '../views/login.php'; // Incluye el HTML con el mensaje de error
            exit();
        }
    }
} else {
    echo "No se encontró un usuario con ese correo.";
}

$stmt->close();
$conn->close();
?>
