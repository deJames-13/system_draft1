<?php

session_start();
if (!isset($_SESSION['adminId']) || !isset($_GET['id']) || $_SESSION['userRoleId'] == 4) {
    header('Location: ../');
    exit;
}

require_once '../../scripts/db-config.php';

try {
    $dbc =  new DatabaseConfig();


    $id = isset($_GET['id']) ?  $_GET['id'] : null;

    $image_dir = $dbc->select('user', ['image_dir'], ['id' => $id])[0]['image_dir'];

    if ($image_dir && json_decode($image_dir) !== null) {
        $images = json_decode($image_dir, true);
        foreach ($images as $image) {
            $path = $image['path'];
            if (file_exists($path)) {
                unlink($path);
            }
        }
    } else if (file_exists($image_dir)) {
        unlink("$image_dir");
    }


    $res = $dbc->delete_from(
        tableName: 'user',
        where: ["id" => $id]
    );
    $res = $dbc->delete_from(
        tableName: 'login',
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
