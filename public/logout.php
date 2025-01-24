<?php
// Iniciar sesión.
session_start();

// Destruir todas las variables de sesión.
$_SESSION = [];

// Destruir la sesión.
session_destroy();

// Redirigir al login con un mensaje de confirmación.
header("Location: login.php?status=logged_out");
exit;
