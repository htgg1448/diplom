<?php
require_once __DIR__.'/boot.php';

try {
    $pdo = pdo();
    $roomToken = $_GET['room'];

    $sql = "SELECT * FROM `msg` WHERE `room_id` = '$roomToken'";
    $stmt = $pdo->query($sql);

    if ($stmt->rowCount() > 0) {
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (true) {
                $userStmt = $pdo->prepare("SELECT * FROM `users` WHERE `id` = :id");
                $userStmt->execute(['id' => intval($data['users_id'])]);
                $user = $userStmt->fetch(PDO::FETCH_ASSOC);
                $currentUserStmt = $pdo->prepare("SELECT * FROM `users` WHERE `id` = :id");
                $currentUserStmt->execute(['id' => intval($_SESSION['user_id'])]);
                $currentUser = $currentUserStmt->fetch(PDO::FETCH_ASSOC);
                $userName = $user['username'];
                ?>

                <style>    
                    .button-close {
                        color: #a71b0ffc;
                        background-color: transparent;
                        font-weight: 700;
                        float: right;
                        cursor: pointer;
                        width: 15px;
                        border: none; /* убрать границу у кнопки */
                        background-size: cover; /* размер изображения */
                        background-repeat: no-repeat; /* повтор изображения */
                    }
                </style>
                <p class="<?= (intval($data['users_id']) === intval($_SESSION['user_id'])) ? 'sender' : 'receiver' ?>">
                    <span class="userName">
                        <?php if (intval($data['users_id']) !== intval($_SESSION['user_id'])) {echo $userName .': ';}?>
                    </span>

                    <?=$data["msg"];?>
                    <!-- Кнопка удаления -->
                    <?php if (intval($data['users_id']) === intval($_SESSION['user_id']) || $currentUser["role"] == "admin"): ?>   
                        <button class="button-close" onclick="deleteMessage(<?= $data['message_id'] ?>)">x</button>
                    <?php endif; ?>
                </p>
                <?php
            } else {
                ?>
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                    <script src="js/script.js"></script>
                <!--!>
                <?php
            }
        }
    } else {
        echo "<h3> Начните общение первым!</h3>";
    }
    
} catch (PDOException $e) {
    echo "Ошибка: " . $e->getMessage();
}

?>
