<?php

session_start();
if (empty($_SESSION['adminId']) || empty($_GET['id'])) {
    header("Location: ../account");
    exit;
}

require_once '../../scripts/db-config.php';

try {
    $id = $_GET['id'];

    $image_dir = $dbc->select('user', ['image_dir'], ['id' => $id])[0]['image_dir'];

    if (json_decode($image_dir) !== null) {
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
