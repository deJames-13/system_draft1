<?php

session_start();
require_once '../scripts/db-config.php';

if (!isset($_SESSION['userId'])) {
    header('Location: ../account/login.php');
    exit;
}
if (empty($_POST['selected_cart_ids'])) {
    header('Location: ../shop/?page=cart');
    exit;
}

try {

    $cart_ids = explode(',', $_POST['selected_cart_ids']);
    $cart_items = $_SESSION['selected_cart_items'];
    $placeholders = implode(',', array_fill(0, count($cart_ids), '?'));

    $shippingType = $_POST['shippingType'];
    $customerId = $_SESSION['userId'];

    $dbc = new DatabaseConfig();
    $res = $dbc->insert_into(
        tableName: 'order',
        data: [
            'customer_id' => $customerId,
            'shipping_type' => $shippingType,
        ]
    );
    $orderId = $dbc->getConnection()->insert_id;
    foreach ($cart_items as $item) {
        $res = $dbc->insert_into(
            tableName: 'order_has_product',
            data: [
                'order_id' => $orderId,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'cost' => $item['total_cost'],
            ]
        );
        $res = $dbc->delete_from(
            tableName: "cart",
            where: ["id" => $item['id']]
        );
    }
    header("Location: ../shop/?page=orders&status=$res");
    exit;
} catch (Exception $ex) {
    echo $dbc->getQuery();
    echo $ex->getMessage();
}
