<?php
// Incluir la configuración y las clases necesarias.
require '../config/db.php'; // conexión PDO
require '../src/Auth.php'; // autenticación usuario

// Verifica si el usuario está autenticado.
$auth = new Auth($pdo); // Crea una instancia de la clase Auth.
if (!$auth->isAuthenticated()) {
    // Si el usuario no está autenticado, redirigir al login.
    header("Location: login.php");
    exit;
}

// Inicializar variables para mensajes y errores.
$mensaje = "";
$error = "";

// Obtener todos los actores de la base de datos para el select
$stmt = $pdo->prepare("SELECT id, nombre FROM actor ORDER BY nombre ASC");
$stmt->execute();
$actores = $stmt->fetchAll();

// Procesar el formulario al enviar.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos enviados.
    $titulo = $_POST['titulo'] ?? '';
    $tipo_video = $_POST['tipo_video'] ?? '';
    $fecha_estreno = $_POST['fecha_estreno'] ?? '';
    $duracion = $_POST['duracion'] ?? ''; // Duración del video
    $actores_seleccionados = $_POST['actores'] ?? [];


    // Validar que todos los campos estén llenos.
    if (empty($titulo) || empty($tipo_video) || empty($fecha_estreno) || empty($duracion)) {
        $error = "Todos los campos son obligatorios.";
    } else {
        // Intentar insertar los datos en la base de datos.
        try {
            // Insertar el video
            $stmt = $pdo->prepare("INSERT INTO video (titulo, tipo_video, fecha_estreno, minuto_duracion) VALUES (:titulo, :tipo_video, :fecha_estreno, :duracion)");
            $stmt->bindParam(':titulo', $titulo);
            $stmt->bindParam(':tipo_video', $tipo_video);
            $stmt->bindParam(':fecha_estreno', $fecha_estreno);
            $stmt->bindParam(':duracion', $duracion); // Insertar duración
            $stmt->execute();

            // Obtener el ID del video recién insertado
            $video_id = $pdo->lastInsertId();

            // Insertar las relaciones actor-video
            if (!empty($actores_seleccionados)) {
                $stmt = $pdo->prepare("INSERT INTO video_actor (actor, video) VALUES (:actor, :video)");
                foreach ($actores_seleccionados as $actor_id) {
                    $stmt->bindParam(':actor', $actor_id);
                    $stmt->bindParam(':video', $video_id);
                    $stmt->execute();
                }
            }

            // Redirigir con un mensaje de éxito.
            header("Location: show_videos.php?status=added");
            exit;
        } catch (Exception $e) {
            $error = "Ocurrió un error al intentar guardar el video: " . $e->getMessage();
        }
    }
}

// Obtener los tipos de videos (película o serie) desde la base de datos.
$stmt = $pdo->prepare("SELECT id, tipo FROM tipo_video ORDER BY tipo ASC");
$stmt->execute();
$tipos_video = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Video</title>
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
            color:  #4e79a7;
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

        .error {
            color: red;
        }

        .message {
            margin-top: 10px;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <header>
        <h1>Añadir Nuevo Video</h1>
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
        <h2>Formulario para añadir un video</h2>

        <!-- Mostrar mensajes de error o éxito -->
        <?php if (!empty($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <!-- Formulario -->
        <form method="POST" action="add_video.php">
            <div>
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($_POST['titulo'] ?? ''); ?>" required>
            </div>
            <div>
                <label for="tipo_video">Tipo de Video:</label>
                <select id="tipo_video" name="tipo_video" required>
                    <option value="">Seleccionar tipo</option>
                    <?php foreach ($tipos_video as $tipo): ?>
                        <option value="<?php echo $tipo['id']; ?>" <?php echo (isset($_POST['tipo_video']) && $_POST['tipo_video'] == $tipo['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($tipo['tipo']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="fecha_estreno">Fecha de Estreno:</label>
                <input type="date" id="fecha_estreno" name="fecha_estreno" value="<?php echo htmlspecialchars($_POST['fecha_estreno'] ?? ''); ?>" required>
            </div>
            <div>
                <label for="duracion">Duración (en minutos):</label>
                <input type="number" id="duracion" name="duracion" value="<?php echo htmlspecialchars($_POST['duracion'] ?? ''); ?>" required>
            </div>
            <div>
                <label for="actores">Seleccionar Actores:</label>
                <select id="actores" name="actores[]" multiple>
                    <?php foreach ($actores as $actor): ?>
                        <option value="<?php echo $actor['id']; ?>">
                            <?php echo htmlspecialchars($actor['nombre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit">Añadir Video</button>
        </form>
    </section>
</body>

</html>
