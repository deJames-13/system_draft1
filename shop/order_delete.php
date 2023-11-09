<?php
require_once '../scripts/db-config.php';
session_start();
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
    $id = $_GET['id'];
    if ($isItem) {
        $dbc = new DatabaseConfig();

        $c = $dbc->select("order_has_product", where: ["order_id" => "$id"]);
        $c = count($c);


        $res = $dbc->delete_from(
            tableName: "order_has_product",
            where: [
                'order_id' => "$id",
            ]
        );

        if ($c == 1) {
            $dbc->delete_from(
                tableName: "`order`",
                where: [
                    'id' => "$id",
                ]
            );
        }
    } else {
        $dbc = new DatabaseConfig();
        $res = $dbc->delete_from(
            tableName: "`order`",
            where: [
                'id' => "$id",
            ]
        );
    }
    if ($res) {
        header("Location: ./?page=orders&res=item_delete_success");
        exit;
    } else {

        header("Location: ./?page=orders&res=error");
        exit;
    }
} catch (Exception $ex) {
    echo $dbc->getQuery();
    echo $ex->getMessage();
}
