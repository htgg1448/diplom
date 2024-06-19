<?php
// Подключение к базе данных
$db = new PDO('mysql:host=127.0.0.1;dbname=OnlineChat', 'root', '');
// Получение ID сообщения из запроса
$message_id = $_POST['message_id'];

// Удаление сообщения из базы данных
$sql = "DELETE FROM msg WHERE message_id = :message_id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':message_id', $message_id);
$stmt->execute();