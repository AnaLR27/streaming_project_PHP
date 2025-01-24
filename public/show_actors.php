<?php
// Incluir la configuración y las clases necesarias.
require '../config/db.php'; // conexión PDO 
require '../src/Auth.php'; // autenticación usuario
require '../src/User.php'; // datos del usuario

// Verifica si el usuario está autenticado.
$auth = new Auth($pdo);  // Crea una instancia de la clase Auth.
$user = new User($pdo);  // Crea una instancia de la clase User.

if (!$auth->isAuthenticated()) {
    // Si el usuario no está autenticado, redirigir al login.
    header("Location: login.php");
    exit;
}

// Obtener los datos del usuario autenticado.
$userData = $user->getUserData();

// Consulta SQL para obtener todos los actores (nombre y películas asociadas)
$stmt = $pdo->prepare("SELECT actor.id, actor.nombre, GROUP_CONCAT(video.titulo SEPARATOR ', ') AS peliculas 
FROM actor
LEFT JOIN video_actor ON video_actor.actor = actor.id
LEFT JOIN video ON video_actor.video = video.id
GROUP BY actor.id, actor.nombre
ORDER BY actor.id;
");

// EJECUTAMOS LA CONSULTA
$stmt->execute();
// FETCH DE TODOS LOS RESULTADOS
$actores = $stmt->fetchAll();

// TOTAL RESULTADOS
$stmt = $pdo->prepare("SELECT COUNT(*) FROM `actor`;");
$stmt->execute();
$totalRegistros = $stmt->fetchColumn();

// MENSAJE TRAS DELETE
if (isset($_GET['status'])) {
    switch ($_GET['status']) {
        case 'added':
            $mensaje = '<p style="color: green;">El intérprete se añadió correctamente.</p>';
            break;
        case 'updated':
            $mensaje = '<p style="color: green;">El intérprete se actualizó correctamente.</p>';
            break;
        case 'error':
            $mensaje = '<p style="color: red;">Ocurrió un error al intentar realizar la operación.</p>';
            break;
        case 'invalid_id':
            $mensaje = '<p style="color: red;">El ID del actor/actriz no es válido.</p>';
            break;
        default:
            $mensaje = ''; // Si no se pasa ningún status válido
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Actores y Actrices</title>
    <!-- Enlace a Bootstrap CSS (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Enlace a Google Fonts (Roboto) -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: rgb(226, 205, 197); /* Fondo beige */
        }

        header {
            background-color: rgb(200, 110, 72);
            color: white;
            padding: 20px;
            text-align: center;
        }

        h1, h2 {
            font-weight: 500;
        }

        nav ul {
            list-style: none;
            padding: 0;
        }

        nav ul li {
            display: inline;
            margin-right: 10px;
        }

        nav ul li a {
            color: white;
            font-weight: bold;
            text-decoration: none;
        }

        nav ul li a:hover {
            text-decoration: none;
            color: #2c4f73; /* Azul oscuro para hover */

        }

        main {
            margin: 20px;
        }

        .video-details p {
            font-size: 1.2rem;
            line-height: 1.6;
        }

        .table th,
        .table td {
            text-align: center;
        }

        .table th {
            background-color: #4e79a7;
            color: white;
        }

        .btn-custom {
            background-color: #4e79a7;
            color: white;
            border-color: #4e79a7;
        }

        .btn-custom:hover {
            background-color: #5f3381;
            border-color: #5f3381;
        }

        .table-striped tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }

    </style>
</head>

<body>
    <header>
        <h1>Listado de Actores y Actrices</h1>
        <nav>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="show_videos.php">Ver listado de videos</a></li>
                <li><a href="show_actors.php">Ver listado de actores</a></li>
                <li><a href="add_video.php">Añadir video</a></li>
                <li><a href="add_actor.php">Añadir actor</a></li>
            </ul>
        </nav>
    </header>

    <section class="container my-5">

        <!-- Mostrar mensajes basados en el parámetro status -->
        <?php if (isset($_GET['status'])) {
            echo  $mensaje;
        } ?>


        <p>A continuación se muestra el listado de todos los intérpretes registrados:</p>
        <p>Total: <?php echo $totalRegistros ?> </p>

        <!-- Si hay actores, los mostramos en una tabla -->
        <?php if (count($actores) > 0): ?>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Películas en las que aparece</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($actores as $actor): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($actor['id']); ?></td>
                            <td><?php echo htmlspecialchars($actor['nombre']); ?></td>
                            <td>
                                <?php echo !empty($actor['peliculas']) ? htmlspecialchars($actor['peliculas']) : 'No tiene películas'; ?>
                            </td>
                            <td>
                                <a href="edit_actor.php?id=<?php echo $actor['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay actores registrados.</p>
        <?php endif; ?>
    </section>

    <!-- Incluir Bootstrap JS y Popper.js (CDN) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>
