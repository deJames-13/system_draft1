<?php

session_start();

require_once '../../scripts/db-config.php';

if (empty($_GET['id']) || empty($_SESSION['adminId'])) {
    header('Location: ./');
    exit;
}

try {
    $dbc = new DatabaseConfig();

    $res = $dbc->delete_from(
        tableName: "product",
        where: [
            "id" => $_GET['id']
        ]
    );

    if ($res) {
        header('Location: ../?page=inventory&res=deleteitemsuccess');
        exit;
    } else {
        header('Location: ../?page=inventory&res=deleteitemfailed');
        exit;
    }
} catch (Exception $ex) {
    echo $ex->getMessage();
}
