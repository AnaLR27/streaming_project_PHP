<?php
class ActorManager {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllActors() {
        $stmt = $this->pdo->query("SELECT * FROM actors");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addActor($name) {
        $stmt = $this->pdo->prepare("INSERT INTO actors (name) VALUES (:name)");
        return $stmt->execute(['name' => $name]);
    }

    public function updateActor($id, $name) {
        $stmt = $this->pdo->prepare("UPDATE actors SET name = :name WHERE id = :id");
        return $stmt->execute(['id' => $id, 'name' => $name]);
    }
}
?>
