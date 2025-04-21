<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "vkusnaya_kuhnya";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_errno) {  
    die("Ошибка подключения: " . $conn->connect_error . " (" . $conn->connect_errno . ")");
}

$conn->set_charset("utf8");
?>
