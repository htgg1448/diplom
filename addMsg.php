<?php

$msg = $_GET["msg"];
$roomId = $_GET["room"];
    require_once __DIR__.'/boot.php';

if (!empty($msg)) {
    try {
        $pdo = pdo();

        // Получение пользователя из таблицы `users`
        $stmt = $pdo->prepare("SELECT * FROM `users` WHERE `id` = :id");
        $stmt->execute(['id' => $_SESSION['user_id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        // Проверка, что пользователь найден
        if (!$user) {
            throw new Exception("Пользователь не найден");
        }

        $userId = $user['id'];

        // Подготовленный запрос для вставки данных
        $sql = "INSERT INTO `msg` (`msg`, `room_id`, `users_id`) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);

        // Привязка параметров и выполнение запроса
        $stmt->bindParam(1, $msg, PDO::PARAM_STR);
        $stmt->bindParam(2, $roomId, PDO::PARAM_INT);
        $stmt->bindParam(3, $userId, PDO::PARAM_INT);
        $stmt->execute();

        echo "Готово";
    } catch (Exception $e) {
        echo "Ошибка: " . $e->getMessage();
    }
} else {
    echo "Сообщение не должно быть пустым";
}

