<?php

session_start();


if (empty($_GET['id']) || empty($_SESSION['adminId'])) {
    header('Location: ./');
    exit;
}

require_once '../../scripts/db-config.php';
require_once '../../scripts/handle-images.php';
try {
    $dbc = new DatabaseConfig();


    $image_dir = $dbc->select('product', ['image_dir'], ['id' => $_GET['id']])[0]['image_dir'];
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
