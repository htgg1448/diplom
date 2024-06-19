<?php
require_once __DIR__.'/boot.php';

if (isset($_POST['delete_button'])) {
    try {
        $pdo = pdo();
        $id = $_POST['roomId'];
        $sql = "DELETE FROM room WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        echo "Комната удалена";
        header('Location: indexpage.php');
        die;
    } catch (PDOException $e) {
        echo "Ошибка удаления комнаты: " . $e->getMessage();
    }
}