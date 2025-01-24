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

// Verificar si se recibe el ID del video por la URL.
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $videoId = $_GET['id'];

    // Primero, eliminar las relaciones de actores con este video
    $stmt = $pdo->prepare("DELETE FROM video_actor WHERE video = :video_id");
    $stmt->bindParam(':video_id', $videoId, PDO::PARAM_INT);
    $stmt->execute();
    
    // Consulta SQL para eliminar el video.
    $stmt = $pdo->prepare("DELETE FROM video WHERE id = :id");
    $stmt->bindParam(':id', $videoId, PDO::PARAM_INT);

    // Intentar ejecutar la consulta.
    if ($stmt->execute()) {
        // Redirigir a la lista de videos con un mensaje de éxito.
        header("Location: show_videos.php?status=deleted");
        exit;
    } else {
        // Si ocurre un error, redirigir con un mensaje de error.
        header("Location: show_videos.php?status=error");
        exit;
    }
} else {
    // Si no se proporciona un ID válido, redirigir con un mensaje de error.
    header("Location: show_videos.php?status=invalid_id");
    exit;
}
