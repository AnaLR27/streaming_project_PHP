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
    header("Location: show_actors.php?status=invalid_id");
    exit;
}

$actorId = $_GET['id'];

// Obtener los datos del actor para mostrar en el formulario.
$stmt = $pdo->prepare("SELECT id, nombre FROM actor WHERE id = :id");
$stmt->execute(['id' => $actorId]);
$actor = $stmt->fetch();

if (!$actor) {
    header("Location: show_actors.php?status=invalid_id");
    exit;
}

// Obtener las películas en las que participa el actor.
$stmt = $pdo->prepare("SELECT v.id, v.titulo FROM video v 
                       JOIN video_actor va ON v.id = va.video 
                       WHERE va.actor = :actor_id");
$stmt->execute(['actor_id' => $actorId]);
$peliculasDelActor = $stmt->fetchAll();

// Si el formulario se envió, procesar los datos.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);

    // Validación básica.
    if (empty($nombre)) {
        $error = "Todos los campos son obligatorios.";
    } else {
        // Actualizar los datos en la base de datos.
        $stmt = $pdo->prepare("UPDATE actor SET nombre = :nombre WHERE id = :id");
        $resultado = $stmt->execute([
            'nombre' => $nombre,
            'id' => $actorId
        ]);

        if ($resultado) {
            header("Location: show_actors.php?status=updated");
            exit;
        } else {
            $error = "Ocurrió un error al intentar actualizar el actor.";
        }
    }
}

// Eliminar actor de una película
if (isset($_GET['remove_video']) && is_numeric($_GET['remove_video'])) {
    $videoId = $_GET['remove_video'];

    // Eliminar la relación actor-video
    $stmt = $pdo->prepare("DELETE FROM video_actor WHERE actor = :actor_id AND video = :video_id");
    $stmt->execute([
        'actor_id' => $actorId,
        'video_id' => $videoId
    ]);

    // Redirigir a la misma página para actualizar la lista de películas.
    header("Location: edit_actor.php?id=$actorId");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Actor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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
        <h1>Editar Actor / Actriz</h1>
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
        <h2>Editar Información del intérprete</h2>

        <!-- Mostrar errores si existen -->
        <?php if (isset($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <!-- Formulario de edición -->
        <form action="" method="POST">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($actor['nombre']); ?>" required>
            <button type="submit">Guardar Cambios</button>
        </form>

        <h3>Películas en las que participa</h3>
        <?php if (count($peliculasDelActor) > 0): ?>
            <ul>
                <?php foreach ($peliculasDelActor as $pelicula): ?>
                    <li class="actor-list">
                        <?php echo htmlspecialchars($pelicula['titulo']); ?>
                        <a href="edit_actor.php?id=<?php echo $actorId; ?>&remove_video=<?php echo $pelicula['id']; ?>" onclick="return confirm('¿Estás seguro de eliminar a este actor de la película?');">Eliminar de esta película</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Este actor no está asignado a ninguna película.</p>
        <?php endif; ?>
    </section>
</body>

</html>
