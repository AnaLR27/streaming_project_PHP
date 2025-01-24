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

// Verificar si se ha recibido un ID válido para edición.
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: show_videos.php?status=invalid_id");
    exit;
}

$videoId = $_GET['id'];

// Obtener los datos del video para mostrar en el formulario.
$stmt = $pdo->prepare("SELECT id, titulo, tipo_video, fecha_estreno, minuto_duracion FROM video WHERE id = :id");
$stmt->execute(['id' => $videoId]);
$video = $stmt->fetch();

if (!$video) {
    header("Location: show_videos.php?status=invalid_id");
    exit;
}

// Obtener la lista de tipos de videos.
$stmt = $pdo->prepare("SELECT id, tipo FROM tipo_video ORDER BY tipo");
$stmt->execute();
$tiposVideo = $stmt->fetchAll();

// Obtener los actores actuales que participan en este video.
$stmt = $pdo->prepare("SELECT a.id, a.nombre FROM actor a 
                       JOIN video_actor va ON a.id = va.actor 
                       WHERE va.video = :video_id");
$stmt->execute(['video_id' => $videoId]);
$actoresEnVideo = $stmt->fetchAll();

// Si el formulario se envió, procesar los datos.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo']);
    $tipoVideo = $_POST['tipo_video'];
    $fechaEstreno = $_POST['fecha_estreno'];
    $duracion = $_POST['duracion'];

    // Validación básica.
    if (empty($titulo) || empty($tipoVideo) || empty($fechaEstreno) || empty($duracion)) {
        $error = "Todos los campos son obligatorios.";
    } elseif (!is_numeric($tipoVideo)) {
        $error = "El tipo de video seleccionado no es válido.";
    } else {
        // Actualizar los datos en la base de datos.
        $stmt = $pdo->prepare("UPDATE video SET titulo = :titulo, tipo_video = :tipo_video, fecha_estreno = :fecha_estreno, minuto_duracion = :duracion WHERE id = :id");
        $resultado = $stmt->execute([
            'titulo' => $titulo,
            'tipo_video' => $tipoVideo,
            'fecha_estreno' => $fechaEstreno,
            'duracion' => $duracion,
            'id' => $videoId
        ]);

        if ($resultado) {
            header("Location: show_videos.php?status=updated");
            exit;
        } else {
            $error = "Ocurrió un error al intentar actualizar el video.";
        }
    }
}

// Eliminar actor de la película
if (isset($_GET['remove_actor']) && is_numeric($_GET['remove_actor'])) {
    $actorId = $_GET['remove_actor'];

    // Eliminar la relación actor-video
    $stmt = $pdo->prepare("DELETE FROM video_actor WHERE actor = :actor_id AND video = :video_id");
    $stmt->execute([
        'actor_id' => $actorId,
        'video_id' => $videoId
    ]);

    // Redirigir a la misma página para actualizar la lista de actores.
    header("Location: edit_video.php?id=$videoId");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Video</title>
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

        section {
            margin: 20px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        form label {
            font-weight: bold;
        }

        form input, form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        form button {
            background-color: #4e79a7;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        form button:hover {
            background-color: rgb(200, 110, 72);
        }

        .actor-list ul {
            list-style-type: none;
            padding: 0;
        }

        .actor-list li {
            margin-bottom: 10px;
        }

        .actor-list a {
            color: red;
            text-decoration: none;
        }

        .actor-list a:hover {
            text-decoration: underline;
        }

        .error {
            color: red;
        }
    </style>
</head>

<body>
    <header>
        <h1>Editar Video</h1>
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

    <section>
        <h2>Editar Información del Video</h2>

        <!-- Mostrar errores si existen -->
        <?php if (isset($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <!-- Formulario de edición -->
        <form action="" method="POST">
            <label for="titulo">Título:</label><br>
            <input type="text" name="titulo" id="titulo" value="<?php echo htmlspecialchars($video['titulo']); ?>" required><br><br>

            <label for="tipo_video">Tipo de Video:</label><br>
            <select name="tipo_video" id="tipo_video" required>
                <option value="">Selecciona un tipo</option>
                <?php foreach ($tiposVideo as $tipo): ?>
                    <option value="<?php echo $tipo['id']; ?>" <?php echo $tipo['id'] == $video['tipo_video'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($tipo['tipo']); ?>
                    </option>
                <?php endforeach; ?>
            </select><br><br>

            <label for="fecha_estreno">Fecha de Estreno:</label><br>
            <input type="date" name="fecha_estreno" id="fecha_estreno" value="<?php echo htmlspecialchars($video['fecha_estreno']); ?>" required><br><br>

            <label for="duracion">Duración (en minutos):</label><br>
            <input type="number" name="duracion" id="duracion" value="<?php echo htmlspecialchars($video['minuto_duracion']); ?>" required><br><br>

            <button type="submit">Guardar Cambios</button>
        </form>

        <h3>Actores Participantes</h3>
        <div class="actor-list">
            <?php if (count($actoresEnVideo) > 0): ?>
                <ul>
                    <?php foreach ($actoresEnVideo as $actor): ?>
                        <li>
                            <?php echo htmlspecialchars($actor['nombre']); ?>
                            <a href="edit_video.php?id=<?php echo $videoId; ?>&remove_actor=<?php echo $actor['id']; ?>" onclick="return confirm('¿Estás seguro de eliminar a este actor?');">Eliminar</a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No hay actores asignados a este video.</p>
            <?php endif; ?>
        </div>
    </section>
</body>

</html>
