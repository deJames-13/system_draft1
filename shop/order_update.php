<?php

session_start();
require_once '../scripts/db-config.php';
if (!isset($_SESSION['userId'])) {
    header("Location: ./?page=login");
    exit;
}

$isItem = $_GET["type"] == "item" && is_numeric($_GET['item']);

if (!is_numeric($_GET['id'])) {
    header("Location: ./?page=orders");
    exit;
}


try {
    $dbc = new DatabaseConfig();
    $id = $_GET['id'];
    if ($isItem) {
        $quantity = $_GET['qty'];
        $subTotal = $_GET['sub'];
        $productId = $_GET['item'];
        $res = $dbc->update_into(
            tableName: 'order_has_product',
            data: [
                'quantity' => $quantity,
                'cost' => $subTotal,
            ],
            where: [
                'order_id' => $id,
                'product_id' => $productId
            ]
        );
    } else {
        $customerId = $_SESSION['userId'];
        $shippingType = $_POST['shippingType'];
        $productId = $_POST['productId'];
        $quantity = $_POST['quantity'];
        $subTotal = $_POST['subtotal'];
        $cost = $_POST['totalCost'];
        switch (strtolower($shippingType)) {
            case 'priority':
                $interval = 1;
                break;
            case 'express':
                $interval = 3;
                break;
            default:
                $interval = 5;
                break;
        }

        $res = $dbc->update_into(
            tableName: '`order`',
            data: [
                'customer_id' => $customerId,
                'shipping_type' => $shippingType,
            ],
            where: [
                'id' => $id,
            ]
        );
    }


    if ($res && !$isItem) {
        header("Location: ./?page=orders&res=order_update_success");
        exit;
    } else if ($res) {
        header("Location: ./?page=orders&res=order_item_update_success");
        exit;
    }
    header("Location: ./?page=orders");
    exit;
} catch (Exception $ex) {
    echo $dbc->getQuery();
    echo $ex->getMessage();
}


exit;
