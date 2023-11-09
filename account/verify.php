<?php
session_start();
require_once '../scripts/db-config.php';



if (empty($_POST['action'])) {
    return;
}

$userName;
$passWord;

if (isset($_POST['username'])) {
    $userName = $_POST['username'];
}

if (isset($_POST['password'])) {
    $passWord = $_POST['password'];
}

if (empty($userName) || empty($passWord)) {
    header("Location: ./login.php");
    exit();
}




try {
    $dbc = new DatabaseConfig();
    $result = $dbc->select(
        tableName: 'customer',
        where: [
            "username" => $userName,
            "password" => $passWord
        ]
    )[0];
} catch (Exception $e) {
    echo $e->getMessage();
}




if (empty($result)) {
    header("Location: ./login.php");
    exit();
} else {
    $_SESSION['userId'] = $result["id"];
    $_SESSION['userName'] = $result["username"];
    header("Location: ../shop/");

    exit();
}
