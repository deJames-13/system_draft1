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
    $res = $dbc->update_into(
        tableName: "cart",
        data: [
            "quantity" => $_GET['qty']
        ],
        where: [
            "id" => $_GET['id']
        ]
    );
    echo $res ? header("Location: ./?page=cart&res=$res") :  "Internal error";
} catch (Exception $ex) {
    //throw $th;
    echo $ex->getMessage();
}
