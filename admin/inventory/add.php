<?php

session_start();
require_once '../../scripts/db-config.php';


if (empty($_POST) || empty($_SESSION['adminId'])) {
    header('Location: ./');
    exit;
}

try {
    $dbc = new DatabaseConfig();

    $res = $dbc->insert_into(
        tableName: "product",
        data: [
            "item_name" => $_POST['item_name'],
            "price" => $_POST['price'],
            "description" => $_POST['description'],
            "stock_quantity" => $_POST['stock_quantity'],
            "brand" => $_POST['brand'],
            "supplier_id" => $_POST['supplier'],
            "created_at" => date('Y-m-d H:i:s'),
            "created_by" => $_SESSION['adminName'],
            "last_modified_at" => date('Y-m-d H:i:s'),
            "last_modified_by" => $_SESSION['adminName'],
        ]
    );

    if ($res) {
        header('Location: ../?page=inventory&res=additemsuccess');
        exit;
    } else {
        header('Location: ../?page=inventory&res=additemfailed');
        exit;
    }
} catch (Exception $ex) {
    echo $ex->getMessage();
}
