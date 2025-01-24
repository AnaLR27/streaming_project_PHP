<?php
require '../config/db.php';
require '../src/Auth.php';

$auth = new Auth($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($auth->login($username, $password)) {
        header('Location: dashboard.php');
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}

// status
$alertScript = '';

if (isset($_GET['status'])) {
    if ($_GET['status'] === 'logged_out') {
        $alertScript = "<script>alert('Sesión cerrada correctamente.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <!-- Enlace a Bootstrap CSS (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Enlace a Google Fonts (Roboto) -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;

            background-color: rgb(200, 110, 72);
            /* Fondo beige */
            padding-top: 50px;
        }

        .container {
            max-width: 400px;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-custom {
            background-color: #4e79a7;
            /* Azul suave */
            border-color: #4e79a7;
            /* Azul suave para el borde */
            color: white;
        }

        .btn-custom:hover {
            color: white;
            background-color: #2c4f73;
            /* Azul oscuro para hover */
            border-color: #2c4f73;
            /* Azul oscuro para el borde en hover */
        }

        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }

        a {
            color: white;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Card de Inicio de Sesión -->
                <div class="card">
                    <div class="card-body">
                        <h2 class="text-center mb-4">Iniciar Sesión</h2>

                        <!-- Mostrar mensajes de alerta -->
                        <?php if (!empty($alertScript)) echo $alertScript; ?>

                        <!-- Formulario de Login -->
                        <form method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Usuario:</label>
                                <input type="text" name="username" id="username" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña:</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-custom w-100">Iniciar Sesión</button>
                        </form>

                        <!-- Mostrar mensaje de error si existe -->
                        <?php if (!empty($error)): ?>
                            <p class="error-message text-center"><?php echo htmlspecialchars($error); ?></p>
                        <?php endif; ?>

                    </div>
                </div>

                <div class="text-center mt-3">
                    <p>¿No tienes cuenta? </p>
                    <a href="register.php">Regístrate aquí</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Enlace a Bootstrap JS y Popper.js (CDN) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>