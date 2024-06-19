<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "OnlineChat";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$room_name = $_POST['room_name'];

$count = 1;
$room_token = uniqid('room' . $count);

//проверка на совпадение токена
while (true) {
    $sql_check_token = "SELECT * FROM room WHERE token = '$room_token'";
    $result = $conn->query($sql_check_token);

    if ($result->num_rows == 0) {
        // генерация нового
        break;
    } else {
        // генерация нового, если повторяется
        $count++;
        $room_token = uniqid('room' . $count);
    }
}

$sql = "INSERT INTO room (name, token, isActive) VALUES ('$room_name', '$room_token', 1)";

if ($conn->query($sql) === TRUE) {
    header('Location: /indexpage.php');
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
