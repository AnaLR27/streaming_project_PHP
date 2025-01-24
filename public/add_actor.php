<?php
// Incluir la configuración y las clases necesarias.
require '../config/db.php'; // conexión PDO 
require '../src/Auth.php'; // autenticación usuario

// Verifica si el usuario está autenticado.
$auth = new Auth($pdo);
if (!$auth->isAuthenticated()) {
    // Si el usuario no está autenticado, redirigir al login.
    header("Location: login.php");
    exit;
}

// Consultar todas las películas para el select
$stmt = $pdo->prepare("SELECT id, titulo FROM video ORDER BY titulo");
$stmt->execute();
$peliculas = $stmt->fetchAll();

// Procesar el formulario cuando se envíe.
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los valores del formulario.
    $nombre = trim($_POST['nombre']);
    $pelicula_id = $_POST['pelicula_id'];


    // Validar que no estén vacíos.
    if (empty($nombre)) {
        $message = '<p class="error">Todos los campos son obligatorios.</p>';
    } else {
        try {
            // Insertar el nuevo actor
            $stmt = $pdo->prepare("INSERT INTO actor (nombre) VALUES (:nombre)");
            $stmt->bindParam(':nombre', $nombre);

            if ($stmt->execute()) {
                // Obtener el ID del actor recién insertado
                $actor_id = $pdo->lastInsertId();

                // Insertar la relación actor-película
                $stmt = $pdo->prepare("INSERT INTO video_actor (actor, video) VALUES (:actor, :video)");
                $stmt->bindParam(':actor', $actor_id);
                $stmt->bindParam(':video', $pelicula_id);

                if ($stmt->execute()) {
                    // Redirigir con un mensaje de éxito.
                    header("Location: show_actors.php?status=added");
                    exit;
                } else {
                    $message = '<p class="error">Ocurrió un error al agregar la relación actor-película.</p>';
                }
            } else {
                $message = '<p class="error">Ocurrió un error al agregar el actor.</p>';
            }
        } catch (PDOException $e) {
            $message = '<p class="error">Error: ' . $e->getMessage() . '</p>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Actor</title>
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
            color:  #4e79a7;;
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
        <h1>Añadir Nuevo Actor / Actriz</h1>
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
        <h2>Formulario para Añadir Actor</h2>

        <!-- Mostrar mensaje -->
        <?php if (!empty($message)) echo $message; ?>

        <form action="add_actor.php" method="post">
            <div>
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div>
                <label for="pelicula_id">Selecciona la película:</label>
                <select id="pelicula_id" name="pelicula_id">
                    <option value="">Seleccione una película</option>
                    <?php foreach ($peliculas as $pelicula): ?>
                        <option value="<?php echo $pelicula['id']; ?>"><?php echo htmlspecialchars($pelicula['titulo']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <button type="submit">Añadir Actor</button>
            </div>
        </form>
    </section>
</body>

</html>
