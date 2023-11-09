<?php
session_start();
require_once '../scripts/db-config.php';

if (!isset($_SESSION['userId'])) {
    header('Location: ../account/login.php');
    exit;
}
if (empty($_GET['ids'])) {
    header('Location: ../shop/?page=cart');
    exit;
}

$cart_ids = explode(',', $_GET['ids']);
$placeholders = implode(',', array_fill(0, count($cart_ids), '?'));
$query = <<<SQL
SELECT 
    c.id,
    c.id as cart_id,
    c.customer_id,
    cust.username,
    c.product_id,
    p.item_name,
    p.price,
    c.quantity,
    p.image_dir

    FROM cart as c
    INNER JOIN customer as cust
    ON c.customer_id = cust.id

    INNER JOIN product as p
    ON c.product_id = p.id

    WHERE cust.username = ? AND c.id IN ($placeholders)
    ORDER BY c.id DESC
    ;
SQL;

try {
    $params = array_merge([$_SESSION['userName']], $cart_ids);
    $dbc = new DatabaseConfig();
    $res = $dbc->executeQuery(
        query: $query,
        params: $params
    );

    foreach ($res as $row) {
        print_r($row);
        echo '<br>';
        echo '<br>';
    }
} catch (Exception $ex) {
    echo $dbc->getQuery();
    echo $ex->getMessage();
}
