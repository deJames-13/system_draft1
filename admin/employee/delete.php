<?php

session_start();
if (empty($_SESSION['adminId']) || empty($_GET['id'])) {
    header("Location: ../account");
    exit;
}

require_once '../../scripts/db-config.php';

try {
    $id = $_GET['id'];
    $dbc =  new DatabaseConfig();
    $res = $dbc->delete_from(
        tableName: 'user',
        where: ["id" => $id]
    );


    if ($res) {
        header('Location: ../?page=employees&res=employeedeletesuccess');
    } else {
        header('Location: ../?page=employees&res=employeedeleteerror');
    }
    exit;
} catch (Exception $th) {
    echo $dbc->getQuery();
    echo $th->getMessage();
}
