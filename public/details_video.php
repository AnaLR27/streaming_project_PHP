<?php
// Incluir configuración y clases necesarias
require '../config/db.php';
require '../src/Auth.php';

// Crear una instancia de Auth para verificar si el usuario está autenticado
$auth = new Auth($pdo);

if (!$auth->isAuthenticated()) {
    // Si no está autenticado, redirige al login
    header("Location: login.php");
    exit;
}

// Verificar si se ha proporcionado un ID válido
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<p>Error: ID de video no válido.</p>";
    exit;
}

$videoId = (int)$_GET['id'];

// Consultar los detalles del video en la base de datos
$stmt = $pdo->prepare("SELECT video.id, video.titulo, video.fecha_estreno, tipo_video.tipo as categoria, video.minuto_duracion, GROUP_CONCAT(actor.nombre SEPARATOR ', ') AS actores
FROM video 
INNER JOIN `tipo_video` ON `video`.`tipo_video` = `tipo_video`.`id`
LEFT JOIN `video_actor` on `video_actor`.`video` = `video`.`id`
LEFT JOIN actor on actor.id = video_actor.actor
WHERE video.id = :id");
$stmt->execute(['id' => $videoId]);
$video = $stmt->fetch();

if (!$video) {
    echo "<p>Error: Video no encontrado.</p>";
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Video</title>
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
            text-decoration: underline;
        }

        main {
            margin: 20px;
        }

        .video-details p {
            font-size: 1.2rem;
            line-height: 1.6;
        }

        .btn-back {
            background-color: #4e79a7; /* Azul suave */
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
        }

        .btn-back:hover {
        }
    </style>
</head>

<body>
    <header>
        <h1>Detalles del Video</h1>
        <br>
        <nav>
            <ul>
                <li><a href="javascript:history.back()" class="btn-back">Volver atrás</a></li>
            </ul>
        </nav>
    </header>

    <main class="container video-details">
        <h2><?php echo htmlspecialchars($video['titulo']); ?></h2>
        <p><strong>Fecha de estreno:</strong> <?php echo htmlspecialchars($video['fecha_estreno']); ?></p>
        <p><strong>Categoría:</strong> <?php echo htmlspecialchars($video['categoria']); ?></p>
        <p><strong>Duración:</strong> <?php echo htmlspecialchars($video['minuto_duracion']); ?> minutos</p>
        <p><strong>Actores:</strong> <?php
                                        // Verifica si hay actores asociados al video
                                        if (!empty($video['actores'])) {
                                            echo htmlspecialchars($video['actores']); // Muestra los actores si existen
                                        } else {
                                            echo "Esta película no tiene actores asociados"; // Si no hay actores asociados
                                        }
                                        ?></p>
    </main>

    <!-- Incluir Bootstrap JS y Popper.js (CDN) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>
