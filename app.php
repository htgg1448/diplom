<?php
require_once __DIR__.'/boot.php';

$user = null;

if (check_auth()) {
    // Получим данные пользователя по сохранённому идентификатору
    $stmt = pdo()->prepare("SELECT * FROM `users` WHERE `id` = :id");
    $stmt->execute(['id' => $_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($user) {
    ?>

    <!DOCTYPE html>
    <html>
        <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <link rel="stylesheet" href="css/style.css">
          <title>Чат</title>
          <link rel="icon" href="/img/icon.svg">
        </head>

        <body>
        <?php
            if (isset($_GET['room'])) {
                $stmt = pdo()->prepare("SELECT * FROM `room` WHERE `token` = :token");
                $stmt->execute(['token' => $_GET['room']]);
                $room = $stmt->fetch(PDO::FETCH_ASSOC);
                //var_dump($room);die;
                if ($room['isActive']==1) {
        ?>
            <h1>Чат <<<?=$room['name']?>>></h1>
            <div class="chat">
                <div class="name_button">
                    <a href="indexpage.php">К чатам</a>
                    <div class="user_buttons">
                            <button id="callback-button" class="user_button">Действия</button>
                    </div>
                </div>
                <hr style="margin-top:20px"/> 
                <div class="msg">

                </div>
                <div class="input_msg">
                    <input type="text" id="input_msg" placeholder="Введите сообщение" maxlength="60" required>
                    <input type="hidden" class="room_id" value="<?=$room['id']?>">
                    <button onclick="update()">Отправить</button>
                </div>
            </div>

              <!-- Модальное окно -->
            <div class="modal" id="modal-1">
                <div class="modal__content">
                <button class="modal__close-button"><img src="./img/close.svg" width="12" alt=""></button>
                <!-- Контент модального окна -->
                <h1 class="modal_title">Профиль</h1>
                <?php
                    if ($user['role'] === "admin") {
                ?>
                    <div class="profile_buttons">
                        <form method="post" action="clear_chat.php">
                            <input type="hidden" name="roomToken" value="<?=$room["token"]?>">
                            <input type="hidden" name="roomId" value="<?=$room["id"]?>">
                            <button type="submit" name="clear_button" class="purple_button">Очистить сообщения</button>
                        </form>
                    <?php
                }
                ?>
                        <a class="purple_button" href="user_list.php?room-user-list=<?=$_GET['room'];?>">Участники</a>
                        <form method="post" action="do_logout.php">
                            <button type="submit" class="purple_button">Выйти</button>
                        </form>
                        <?php
                            if ($user['role'] === "admin") {
                        ?>
                        <form method="post" action="delete_room.php">
                            <input type="hidden" name="roomId" value="<?=$room["id"]?>">
                            <button type="submit" name="delete_button"class="red_button" onclick="return confirm('Вы уверены, что хотите удалить эту комнату?');">Удалить комнату</button>
                        </form>
                        <?php
                }
                ?>
                    </div>
                </div>
            </div>
            <!-- Конец окна -->

        <?php
                } else {
                    echo "<center style='position: absolute;top: 45%;width: 100%;'><h1>Ошибка 404 - Не найдено<br><hr> Данная комната не существует или была отключена</h1></center>";
                }
            } else {
                echo "<center style='position: absolute;top: 45%;width: 100%;'><h1>Ошибка 404 - Не найдено<br><hr> Войдите в комнату</h1></center>";
            }
        ?>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script src="js/script.js"></script>
        </body>
    </html>

<?php

} else {
    echo "<center style='position: absolute;top: 45%;width: 100%;'><h1>Ошибка 403 - Не авторизован<br><hr> Пожалуйста, авторизуйтесь</h1></center>";
}