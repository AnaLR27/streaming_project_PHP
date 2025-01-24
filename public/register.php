<?php
// Incluir la configuración y las clases necesarias.
require '../config/db.php'; // conexión PDO
require '../src/Auth.php'; // autenticación usuario

// Inicializar variables para mensajes y errores.
$mensaje = "";
$error = "";

// Procesar el formulario al enviar.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos enviados.
    $usuario = $_POST['usuario'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Validar los datos del formulario.
    if (empty($usuario) || empty($password) || empty($confirm_password)) {
        $error = "Todos los campos son obligatorios.";
    } elseif ($password !== $confirm_password) {
        $error = "Las contraseñas no coinciden.";
    } else {
        // Intentar registrar al usuario.
        try {
            // Comprobar si el correo electrónico ya está registrado.
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE usuario = :usuario");
            $stmt->bindParam(':usuario', $usuario);
            $stmt->execute();
            $exists = $stmt->fetchColumn();

            if ($exists > 0) {
                $error = "El usuario ya está registrado.";
            } else {
                // Insertar el usuario en la base de datos.
                // $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                $stmt = $pdo->prepare("INSERT INTO usuarios (usuario, password) VALUES (:usuario, :password)");
                $stmt->bindParam(':usuario', $usuario);
                $stmt->bindParam(':password', $password /* $hashed_password */);
                $stmt->execute();

                // Redirigir al login con un mensaje de éxito.
                echo "<script>alert('El usuario se registró correctamente.');</script>";
                header("Location: login.php?status=registered");

                exit;
            }
        } catch (Exception $e) {
            $error = "Ocurrió un error al intentar registrar el usuario: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
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
            <div class="col-md-12">
                <!-- Card de Registro -->
                <div class="card">
                    <div class="card-body">
                        <h2 class="text-center mb-4">Crear una Cuenta</h2>

                        <!-- Mostrar mensajes de alerta -->
                        <?php if (!empty($alertScript)) echo $alertScript; ?>

                        <!-- Formulario de Registro -->
                        <form method="POST">
                            <div class="mb-3">
                                <label for="usuario" class="form-label">Usuario:</label>
                                <input type="text" name="usuario" id="usuario" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña:</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirmar Contraseña:</label>
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-custom w-100">Registrarse</button>
                        </form>

                        <!-- Mostrar mensaje de error si existe -->
                        <?php if (!empty($error)): ?>
                            <p class="error-message text-center"><?php echo htmlspecialchars($error); ?></p>
                        <?php endif; ?>

                    </div>
                </div>

                <div class="text-center mt-3">
                    <p>¿Ya tienes cuenta? </p>
                    <a href="login.php">Inicia sesión aquí</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Enlace a Bootstrap JS y Popper.js (CDN) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>