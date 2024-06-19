<?php
require_once __DIR__.'/boot.php';

$BAN = null;

if (isset($_POST['user_id']) && $_POST['user_role'] === "admin") {
  
    try {
        if ($_POST['ban']==="1") {
            $BAN = 1;
        } else {
            $BAN = 0;
        }
    
        $sql = "UPDATE `users` SET `banned` = :banned WHERE `id` = :id";
        $stmt = pdo()->prepare($sql);
    
        $stmt->bindParam(':banned', $BAN, PDO::PARAM_BOOL);
        $stmt->bindParam(':id', intval($_POST['user_id']), PDO::PARAM_INT);
    
        $stmt->execute();
        header('Location: user_list.php?room-user-list=' . $_POST['room_token']);
        die;
    } catch (Exception $e) {
        var_dump($e->getMessage());
    }
} else {
    echo "Invalid Request";
}
