<?php

//$mysqli = new mysqli("localhost", "my_user", "my_password", "world"); 

$mysqli = mysqli_init();
if (!$mysqli) {
    die('mysqli_init завершилась провалом');
}

if (!$mysqli->options(MYSQLI_INIT_COMMAND, 'SET AUTOCOMMIT = 0')) {
    die('Установка MYSQLI_INIT_COMMAND завершилась провалом');
}

if (!$mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, 5)) {
    die('Установка MYSQLI_OPT_CONNECT_TIMEOUT завершилась провалом');
}

if (!$mysqli->real_connect($host, $user, $pass, $db)) {
    die('Ошибка подключения (' . mysqli_connect_errno() . ') '
            . mysqli_connect_error());
}

echo 'MySQL(i) connect <br>' . $mysqli->host_info . "<hr>";

//$mysqli->close();


?>