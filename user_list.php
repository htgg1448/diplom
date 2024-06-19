<?php
require_once __DIR__.'/boot.php';

$user = null;

if (check_auth()) {
    $stmt = pdo()->prepare("SELECT * FROM `users` WHERE `id` = :id");
    $stmt->execute(['id' => $_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Чатик</title>
        <link rel="icon" href="/img/icon.svg">
        <link rel="stylesheet" href="css/style.css">
    </head>
<?php if ($user) {?>
    <body class="nicknames">

    <?php if (isset($_GET['room-user-list'])) { ?>
      <a style="text-decoration: none;" href="app.php?room=<?=$_GET['room-user-list']?>">
          <p style="font-size: 25px;">Вернуться в Чат</p>
      </a>
        <h1 style="text-align: center;">Список пользователей</h1>
      <table class="users">
          <tr>
            <th class="nickname_title">Никнейм</th>
          </tr><br>
    <?php
        $stmt_users = pdo()->prepare("SELECT * FROM `users`");
        $stmt_users->execute();
        while ($row = $stmt_users->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>".$row['username']."</td>";
            if($user['role'] === 'admin' && $row['role'] !== "admin") {
                echo "<td>
                       <form action='ban_user.php' method='POST'>
                            <input type='hidden' name='user_id' value='". $row['id'] ."'>
                            <input type='hidden' name='room_token' value='". $_GET['room-user-list'] ."'>
                            <input type='hidden' name='user_role' value='". $user['role'] ."'>";
                           if ($row['banned']!=1) {
                               echo "<input type='hidden' name='ban' value='1'>
                                     <button class='ban_btn' type='submit'>Заблокировать</button>";
                           } else {
                               echo "<input type='hidden' name='ban' value='0'>
                                     <button class='ban_btn' type='submit'>Разблокировать</button>";
                           }
                echo "</form></td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
         echo "<center style='position: absolute;top: 45%;width: 100%;'><h1>Ошибка 404 - Не найдено<br><hr> Комната не существует</h1></center>";
    }
} else {
    echo "<center style='position: absolute;top: 45%;width: 100%;'><h1>Ошибка 403 - Не авторизован<br><hr> Пожалуйста, авторизуйтесь</h1></center>";
}
?>
    </body>
</html>
