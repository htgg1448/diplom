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
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="stylesheet" href="css/style.css">
        <title>Главная</title>
    </head>
        <body>
            <div class="main-container">
                <div class="heading-block">
                    <h1 class="heading">Привет, <span><?=htmlspecialchars($user['username'])?></span></h1>
                    <div class="heading-description">
                        <h2 class="heading">Выбери чат или создай своё обсуждение!</h2>
                        <div>
                            <form class="search-form" action="search_room.php">
                                <input class="search-form_txt" type="text" name="query" placeholder="Поиск">
                                <button class="search-form_btn">
                                    <img class="search-form_img" src="img/search.svg" alt="image">
                                </button>
                            </form>
                        </div>
                    </div>       
                </div>
                <div class="container">
                    <div class="row">
                        <?php

                        if (isset($_GET["query"]) && $_GET["query"] == "1") {
                            if (isset($_SESSION['search_results'])) {
                                $rows = $_SESSION['search_results'];
                                if (count($rows) < 1) {
                                    echo "<h1 style='color: white;'>Комната не найдена.</h1>";
                                } else {
                                    foreach ($rows as $row) {
                                        ?>
                                        <div class="rooms">
                                            <a class="link-room" href="app.php?room=<?=$row['token']?>"><?=$row['name']?></a>
                                        </div>
                                        <?php
                                    }
                                }

                                unset($_SESSION['search_results']);
                            }
                        } else {
                            $stmt_rooms = pdo()->prepare("SELECT * FROM `room`");
                            $stmt_rooms->execute();
                            $rows = $stmt_rooms->fetchAll(PDO::FETCH_ASSOC);
                            if($rows){
                                foreach ($rows as $row) {
                        ?>
                                <div class="rooms">
                                    <a class="link-room" href="app.php?room=<?=$row['token']?>"><?=$row['name']?></a>
                                </div>
                        <?php 
                                }?>
                                <div class="rooms">
                                    <div class="user_buttons">
                                        <a id="callback-button2" class="link-room-create">Создать +</a>
                                    </div>
                                </div>
                        <?php } else { ?>
                                <div class="">Нет Записей</div>
                        <?php 
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
                    <input type="hidden" class="room_id" value="<?=$room['id']?>">

              <!-- Модальное окно -->
            <div class="modal" id="modal-2">
                <div class="modal__content2">
                <button class="modal__close-button"><img src="./img/close.svg" width="12" alt=""></button>
                <!-- Контент модального окна -->
                <h1 class="modal_title">Создание комнаты</h1>
                    <div>
                        <form method="post" action="create_room.php???">
                            <input type="text" name="room_name" placeholder="Придумайте название чата" maxlength="12" required pattern="[а-яА-ЯёЁ]+">
                            <button class="purple_button", style="float: right;">Создать</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Конец окна -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script src="js/script.js"></script>
        </body>
    </html>

    <?php
    
    } else {
        echo "<center style='position: absolute;top: 45%;width: 100%;'><h1>Ошибка 403 - Не авторизован<br><hr> Пожалуйста, авторизуйтесь</h1></center>";
    }