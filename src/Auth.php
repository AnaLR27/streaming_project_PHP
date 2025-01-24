<?php
/* Clase par autenticación del usuario
*/
class Auth
{
    private $pdo; // Objeto PDO para la conexión a la base de datos.

    // Constructor: recibe un objeto PDO al instanciar la clase.
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
        session_start(); // Inicia la sesión.

    }

    // Método para iniciar sesión.
    public function login($usuario, $password)
    {
        // Consulta para buscar al usuario en la base de datos por su nombre.
        $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE usuario = :usuario");
        $stmt->execute(['usuario' => $usuario]);
        $user = $stmt->fetch();

        // Si el usuario existe y la contraseña coincide.
        if ($user && $password == $user['password']) { // Compara las contraseñas directamente, la linea de abajo es para cuanado se us el hashing

            // if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id']; // Guarda el ID del usuario en la sesión.
            return true;
        }
        return false; // Si no, Fallo en el inicio de sesión.
    }

    // Método para registrar un nuevo usuario.
    public function register($usuario, $password)
    {
        // Hashea la contraseña para almacenarla de forma segura.
        //  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);      
        $stmt = $this->pdo->prepare("INSERT INTO usuarios (usuario, password) VALUES (:usuario, :password)");
        return $stmt->execute(['usuario' => $usuario, 'password' => $password/*$hashedPassword*/]);
    }

    // Método para verificar si un usuario está autenticado.
    public function isAuthenticated()
    {
        return isset($_SESSION['user_id']); // Verifica si el ID del usuario está en la sesión.
    }

    // para eliminar la sesión cuandod el usuario hace un cierre 
    public function logout()
    {
        session_destroy();
    }
}
