<?php


session_start();
require_once '../../scripts/db-config.php';



if (empty($_POST['action'])) {
    header("Location: ./");
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
        tableName: 'login',
        columns: ['id', 'username', 'password'],
        where: [
            "username" => $userName,
        ]
    )[0];
    $role_id = $dbc->select(
        tableName: 'user',
        columns: ['role_id'],
        where: [
            "username" => $userName,
        ]
    )[0];
} catch (Exception $e) {
    echo $e->getMessage();
}

if (empty($result)) {
    header("Location: ./?res=wronguser");
} else {

    // password_verify
    if (!password_verify($passWord, $result["password"])) {
        header("Location: ./?res=wrongpass");
        exit();
    }

    // get user role

    $role = $dbc->select(
        tableName: 'role',
        columns: ['id', 'name'],
        where: [
            "id" => $role_id["role_id"],
        ]
    )[0];

    $_SESSION['adminId'] = $result["id"];
    $_SESSION['adminName'] = $result["username"];
    $_SESSION['userRoleId'] = $role['id'];

    header("Location: ../?res=loginsuccess");
}
exit();
