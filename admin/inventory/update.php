<?php

// echo '<pre>';
// print_r($_POST);
// echo '</pre>';
// exit;

session_start();
if (empty($_SESSION['adminId']) || empty($_POST['action'])) {
    header('Location: ../');
}

try {
    require_once '../../scripts/db-config.php';
    $id = $_POST['item_id'];
    $dbc = new DatabaseConfig();
    $res = $dbc->update_into(
        tableName: 'product',
        data: [
            "item_name" => $_POST['item_name'],
            "price" => $_POST['price'],
            "stock_quantity" => $_POST['quantity'],
            "brand" => $_POST['brand'],
            "supplier_id" => $_POST['supplier'],
        ],
        where: [
            "id" => $id
        ]
    );

    if ($res) {
        header("Location: ../?page=inventory&id=$id&res=updateitemsuccess");
    } else {
        header("Location: ../?page=inventory&id=$id&res=updateitemerror");
    }
} catch (Exception $ex) {
    echo $ex->getMessage();
}
exit;