<?php
session_start();
require_once "../scripts/db-config.php";

if (empty($_SESSION['currentItemID']) && !$_GET['isquickAdd']) {
    header("Location: ./");
    exit();
}

$itemID = $_GET['prodId'];
$customerId = $_SESSION['userId'];
$qty = $_GET['qty'];

$dbc = new DatabaseConfig();
try {

    $itemExists = $dbc->select(
        tableName: "cart",
        where: [
            "customer_id" => $customerId,
            "product_id" => $itemID
        ]
    );

    $qty = $_GET['qty'] + $itemExists[0]['quantity'];
    if (count($itemExists) > 0) {
        $res = $dbc->update_into(
            tableName: "cart",
            data: [
                "quantity" => $qty
            ],
            where: [
                "customer_id" => $customerId,
                "product_id" => $itemID
            ]
        );
    } else {
        $res =  $dbc->insert_into(
            tableName: "cart",
            data: [
                "customer_id" => $customerId,
                "product_id" => $itemID,
                "quantity" => $qty
            ]
        );
    }


    if ($res) {
        header("Location: ./?page=cart");
        exit;
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
