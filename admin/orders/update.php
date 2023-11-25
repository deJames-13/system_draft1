<?php

session_start();

if (!isset($_SESSION["adminId"])) {
    header("Location: ../login.php");
    exit;
}

include_once "../../scripts/db-config.php";


try {

    $status = $_GET["status"];
    $id = $_GET["id"];
    $dbc = new DatabaseConfig();

    if ($status == 'shipping' || $status == 'delivered') {
        $products = $dbc->executeQuery(
            "SELECT product_id, quantity FROM `order_has_product` WHERE `order_id` = ?",
            ["order_id" => $id]
        );
    }

    foreach ($products as $p) {
        $product = $dbc->executeQuery(
            "SELECT stock_quantity FROM `product` WHERE `id` = ?",
            ["id" => $p["product_id"]]
        );

        if ($product[0]["stock_quantity"] == 0) {
            continue;
        }

        $dbc->executeNonQuery(
            "UPDATE `product` SET `stock_quantity` = `stock_quantity` - ? WHERE `id` = ?",
            ["stock_quantity" => $p["quantity"], "id" => $p["product_id"]]
        );
    }



    $res = $dbc->update_into(
        tableName: "`order`",
        data: [
            " `status` " => $status
        ],
        where: [
            "id" => $id
        ]
    );

    if ($res) {
        header("Location: ../?page=orders&res=orderupdatesuccess&order_id=$id&type=$status");
    } else {
        header("Location: ../?page=orders&res=orderupdateerror");
    }
} catch (exception $ex) {
    echo $ex->getMessage();
    header("Location: ../?page=orders&res=orderupdateerror");
}
