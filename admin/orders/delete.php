<?php
session_start();
if (empty($_SESSION["adminId"])) {
    header("Location: ../");
    exit;
}
include_once "../../scripts/db-config.php";

try {
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        $dbc = new DatabaseConfig();
        $res = $dbc->delete_from(
            tableName: " `order` ",
            where: [
                "`id`" => $id,
            ]
        );
        if ($res) {
            header("Location: ../?page=orders&res=orderdeletesuccess&order_id=$id");
            exit;
        } else {
            header("Location: ../?page=orders&res=orderdeleteerror");
            exit;
        }
    }
} catch (Exception $ex) {
    $ex->getMessage();
}
