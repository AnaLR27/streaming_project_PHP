<?php
class User
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getUserData()
    {
        if (isset($_SESSION['user_id'])) {
            $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE id = :id");
            $stmt->execute(['id' => $_SESSION['user_id']]);
            return $stmt->fetch();
        }
        return null;
    }

    public function updateUserProfile($name, $email)
    {
        if (isset($_SESSION['user_id'])) {
            $stmt = $this->pdo->prepare("UPDATE usuarios SET name = :name, email = :email WHERE id = :id");
            return $stmt->execute(['name' => $name, 'email' => $email, 'id' => $_SESSION['user_id']]);
        }
        return false;
    }
}
