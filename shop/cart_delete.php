<?php
session_start();
require_once "../scripts/db-config.php";


if (empty($_GET['id'])) {
    header('Location: ./?page=cart');
    exit;
} else if (!is_numeric($_GET['id'])) {
    header('Location: ./?page=cart');
    exit;
} else if (empty($_SESSION['userId'])) {
    header('Location: ./?page=cart');
    exit;
}

try {
    $dbc = new DatabaseConfig();
    $res = $dbc->delete_from(
        tableName: "cart",
        where: [
            "customer_id" => $_SESSION['userId'],
            "product_id" => $_GET['id']
        ]
    );
    if ($res) {
        header("Location: ./?page=cart&res=cartdeletesuccessfully");
    } else {
        header("Location: ./?page=cart&res=cartdeleteunsucessfully");
    }
    exit;
} catch (Exception $ex) {
    //throw $th;
    echo $ex->getMessage();
}
