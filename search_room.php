<?php
require_once 'boot.php';
session_start();

if (isset($_GET['query'])) {
    $searchTerm = $_GET['query'];
    $pdo = pdo();
    try {
        $stmt = $pdo->prepare("SELECT * FROM room WHERE name LIKE ?");
        $stmt->execute(["%$searchTerm%"]);

        $rows = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $rows[] = $row;
        }

        $_SESSION['search_results'] = $rows;

        header("Location: indexpage.php?query=1");
        exit();
    } catch (PDOException $e) {
        echo "Ошибка: " . $e->getMessage();
    }
}