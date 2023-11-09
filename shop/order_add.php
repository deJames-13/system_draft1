<?php

session_start();
require_once '../scripts/db-config.php';

if (!isset($_SESSION['userId'])) {
    header('Location: ../account/login.php');
    exit;
}

$customerId = $_SESSION['userId'];
$shippingType = $_POST['shippingType'];
$productId = $_POST['productId'];
$quantity = $_POST['quantity'];
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


try {
    $dbc = new DatabaseConfig();

    $res = $dbc->insert_into(
        tableName: 'order',
        data: [
            'customer_id' => $customerId,
            'shipping_type' => $shippingType,
        ]
    );
    $orderId = $dbc->getConnection()->insert_id;
    $res = $dbc->insert_into(
        tableName: 'order_has_product',
        data: [
            'order_id' => $orderId,
            'product_id' => $productId,
            'quantity' => $quantity,
            'cost' => $cost,
        ]
    );

    header('Location: ../shop/?page=orders&status=success');
    $dbc->disconnect();
    exit;
} catch (Exception $ex) {
    echo $dbc->getQuery();
    echo $ex->getMessage();
}
