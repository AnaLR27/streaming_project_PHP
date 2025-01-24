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

// Consulta SQL para obtener todos los videos (películas y series) 
$stmt = $pdo->prepare("SELECT video.id as id, video.titulo as titulo, tipo_video.tipo as tipo, fecha_estreno
FROM `video`
INNER JOIN `tipo_video` ON `video`.`tipo_video` = `tipo_video`.`id` order by video.titulo;
");

// EJECUTAMOS LA CONSULTA
$stmt->execute();
// FETCH DE TODOS LOS RESULTADOS
$videos = $stmt->fetchAll();

// TOTAL RESULTADOS
$stmt = $pdo->prepare("SELECT COUNT(*) FROM `video`;");
$stmt->execute();
$totalRegistros = $stmt->fetchColumn();

// MENSAJE TRAS DELETE
if (isset($_GET['status'])) {
    switch ($_GET['status']) {
        case 'deleted':
            $mensaje = '<p class="alert alert-success">El video se eliminó correctamente.</p>';
            break;
        case 'added':
            $mensaje = '<p class="alert alert-success">El video se añadió correctamente.</p>';
            break;
        case 'updated':
            $mensaje = '<p class="alert alert-success">El video se actualizó correctamente.</p>';
            break;
        case 'error':
            $mensaje = '<p class="alert alert-danger">Ocurrió un error al intentar realizar la operación.</p>';
            break;
        case 'invalid_id':
            $mensaje = '<p class="alert alert-danger">El ID del video no es válido.</p>';
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
    <title>Listado de Videos</title>
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
            background-color: rgb(200, 110, 72); /* Fondo beige */
            padding: 20px;
            color: white;
            text-align: center;
        }

     

        .nav-item a {
            color: rgb(255, 255, 255);
            font-weight: bold;
        }

        .nav-item a:hover {
            color: #2c4f73; /* Azul oscuro para hover */
        }

        .table th,
        .table td {
            text-align: center;
        }

        .table th {
            background-color: #4e79a7; /* Azul suave */
            color: white;
        }

        .table-striped tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }

        /* Estilos para los botones personalizados */
        .btn-custom {
            background-color: #4e79a7; /* Azul suave */
            color: white;
            border-color: #4e79a7; /* Azul suave para el borde */
        }

        .btn-custom:hover {
            background-color: #2c4f73; /* Azul oscuro para hover */
            border-color: #2c4f73; /* Azul oscuro para el borde en hover */
        }

        .btn-info {
            background-color: #17a2b8;
            border-color: #17a2b8;
        }

        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
    </style>
</head>

<body>
    <header>
        <h1>Listado de Videos</h1>
        <nav>
            <ul class="nav justify-content-center">
                <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="show_videos.php">Ver listado de videos</a></li>
                <li class="nav-item"><a class="nav-link" href="show_actors.php">Ver listado de actores</a></li>
                <li class="nav-item"><a class="nav-link" href="add_video.php">Añadir video</a></li>
                <li class="nav-item"><a class="nav-link" href="add_actor.php">Añadir actor</a></li>
            </ul>
        </nav>
    </header>

    <div class="container my-5">
        <!-- Mostrar mensajes basados en el parámetro status -->
        <?php if (isset($_GET['status'])) {
            echo $mensaje;
        } ?>

        <p>A continuación se muestra el listado de todos los videos registrados:</p>
        <p>Total: <?php echo $totalRegistros; ?></p>

        <!-- Si hay videos, los mostramos en una tabla -->
        <?php if (count($videos) > 0): ?>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Tipo de Video</th>
                        <th>Fecha de Estreno</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($videos as $video): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($video['titulo']); ?></td>
                            <td><?php echo htmlspecialchars($video['tipo']); ?></td>
                            <td><?php echo htmlspecialchars($video['fecha_estreno']); ?></td>
                            <td>
                                <a href="details_video.php?id=<?php echo $video['id']; ?>" class="btn btn-info btn-sm">Detalles</a>
                                <a href="edit_video.php?id=<?php echo $video['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="delete_video.php?id=<?php echo $video['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que quieres eliminar este video?')">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay videos registrados.</p>
        <?php endif; ?>
    </div>

    <!-- Incluir Bootstrap JS y Popper.js (CDN) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>
