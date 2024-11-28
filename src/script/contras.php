<?php
$usuarios = [
    ['correo' => 'juan.perez@example.com', 'contraseña' => 'contraseña123'],
    ['correo' => 'ana.gomez@example.com', 'contraseña' => 'password456']
];

foreach ($usuarios as $usuario) {
    $hash = password_hash($usuario['contraseña'], PASSWORD_BCRYPT);
    echo "UPDATE usuarios SET contraseña = '$hash' WHERE correo = '{$usuario['correo']}';<br>";
}
?>
