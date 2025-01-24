<?php
// Incluir la configuración y las clases necesarias.
require '../config/db.php'; // conexión PDO 
require '../src/Auth.php'; // autenticación usuario
require '../src/User.php'; // datos del usuario

// Verifica si el usuario está autenticado
$auth = new Auth($pdo); // Crea una instancia de la clase Auth.
$user = new User($pdo); // Crea una instancia de la clase User.

if (!$auth->isAuthenticated()) {
    // Si el usuario no está autenticado, redirigir al login.
    header("Location: login.php");
    exit;
}

// Obtener los datos del usuario autenticado.
$userData = $user->getUserData();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Gestión de Películas y Series</title>
    <!-- Enlace a Bootstrap CSS (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Enlace a Google Fonts (Roboto) -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: rgb(226, 205, 197);
            /* Fondo beige */
            font-family: 'Roboto', sans-serif;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            margin-top: 30px;
            color: white;
            background-color: rgb(200, 110, 72);
            /* Azul suave para el header */
            padding: 20px;
        }

        .nav-item {
            margin-right: 15px;
        }

        .btn-custom {
            background-color: #4e79a7;
            /* Azul suave */
            border-color: #4e79a7;
            /* Azul suave */
            color: white;
        }

        .btn-custom:hover {
            background-color: #2c4f73;
            /* Azul oscuro */
            border-color: #2c4f73;
            /* Azul oscuro */
        }

        .nav-link {
            font-weight: bold;
        }

        .nav-link:hover {
            color: white;
            /* Azul suave para hover */
            text-decoration: underline;
        }

        .card {
            margin-top: 30px;
            background-color: white;
        }

        .navbar-light .navbar-nav .nav-link {
            color: white;
        }

        .navbar-light .navbar-nav .nav-link:hover {
            color: rgb(200, 110, 72);
            /* Azul suave para los enlaces al pasar el mouse */
        }

        .navbar {
            background-color: #4e79a7;
            /* Azul suave para el header */

        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Encabezado -->
        <header class="header">
            <h1>Bienvenido/a, <?php echo ucfirst(htmlspecialchars($userData['usuario'])); ?>!</h1>
        </header>

        <!-- Barra de navegación -->
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="show_videos.php">Ver listado de videos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="show_actors.php">Ver listado de actores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add_video.php">Añadir video</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add_actor.php">Añadir actor</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Cerrar sesión</a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Card para contenido principal -->
        <div class="card">
            <div class="card-body">
                <p class="card-text">Desde aquí puedes gestionar los videos, actores y más.</p>
            </div>
        </div>
    </div>

    <!-- Enlace a Bootstrap JS y Popper.js (CDN) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>