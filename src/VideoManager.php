<?php
class VideoManager {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllVideos() {
        $stmt = $this->pdo->query("SELECT * FROM videos");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getVideo($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM videos WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addVideo($title, $type, $releaseDate) {
        $stmt = $this->pdo->prepare("INSERT INTO videos (title, type, release_date) VALUES (:title, :type, :releaseDate)");
        return $stmt->execute(['title' => $title, 'type' => $type, 'releaseDate' => $releaseDate]);
    }

    public function updateVideo($id, $title, $type, $releaseDate) {
        $stmt = $this->pdo->prepare("UPDATE videos SET title = :title, type = :type, release_date = :releaseDate WHERE id = :id");
        return $stmt->execute(['id' => $id, 'title' => $title, 'type' => $type, 'releaseDate' => $releaseDate]);
    }

    public function deleteVideo($id) {
        $stmt = $this->pdo->prepare("DELETE FROM videos WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
?>
