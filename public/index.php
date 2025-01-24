<?php
// Incluir la configuración y las clases necesarias
require '../config/db.php'; // conexión PDO
require '../src/Auth.php'; // autenticación usuario

// Verifica si el usuario ya está autenticado
$auth = new Auth($pdo);

if ($auth->isAuthenticated()) {
    // Si el usuario está autenticado, redirigir a una página de inicio o dashboard.
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
    <!-- Enlace a Bootstrap CSS (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Enlace a Google Fonts (Roboto) -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: rgb(200, 110, 72); /* Fondo beige */
            padding-top: 50px;
        }

        .container {
            max-width: 500px;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Estilos para el botón personalizado */
        .btn-custom {
            width: 100%;
            background-color: #4e79a7; /* Azul suave */
            border-color: #4e79a7; /* Azul suave para el borde */
            color: white;
        }

        .btn-custom:hover {
            background-color: #2c4f73; /* Azul oscuro para hover */
            border-color: #2c4f73; /* Azul oscuro para el borde en hover */
        }

        .header-title {
            font-weight: bold;
            font-size: 2rem;
            color: #495057;
        }

        .description {
            color: #6c757d;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Card de Bienvenida -->
                <div class="card">
                    <div class="card-body text-center">
                        <h1 class="header-title mb-4">Bienvenido a nuestro catálogo de streaming</h1>
                        <p class="description mb-4">¿Ya tienes cuenta? Puedes iniciar sesión o registrarte para empezar.</p>

                        <!-- Botones de acción -->
                        <a href="login.php" class="btn btn-custom mb-3">Iniciar sesión</a>
                        <a href="register.php" class="btn btn-custom">Registrarse</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enlace a Bootstrap JS y Popper.js (CDN) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>
