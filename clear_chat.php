<?php
require_once __DIR__.'/boot.php';

if (isset($_POST['clear_button'])) {
    try {
        $pdo = pdo();

        // Очистка таблицы MSG
        $sql = "DELETE FROM msg WHERE room_id = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $_POST["roomId"], PDO::PARAM_INT);
        $stmt->execute();

        echo "Чат очищен";
        header('Location: app.php?room=' . $_POST["roomToken"]);
        die;
    } catch (PDOException $e) {
        echo "Ошибка очистки таблицы: " . $e->getMessage();
    }
}