<?php


session_start();
if (empty($_SESSION['adminId']) || empty($_POST['action'])) {
    header('Location: ../');
}

try {
    require_once '../../scripts/db-config.php';
    require_once '../../scripts/handle-images.php';

    $dbc = new DatabaseConfig();
    $id = $_POST['item_id'];
    $currimages = $dbc->select('product', ['image_dir'], ['id' => $id])[0]['image_dir'];

    $newimages = handleImageUpload('../../img/product', $_FILES['images']);
    if (json_decode($currimages)) {
        $images = $newimages ? array_merge(json_decode($currimages, true), json_decode($newimages, true)) : json_decode($currimages, true);
        $newimages = json_encode($images);
    } else if (file_exists($currimages)) {
        unlink("$currimages");
    }


    $res = $dbc->update_into(
        tableName: 'product',
        data: [
            "item_name" => $_POST['item_name'],
            "price" => $_POST['price'],
            "stock_quantity" => $_POST['quantity'],
            "brand" => $_POST['brand'],
            "supplier_id" => $_POST['supplier'],
            "image_dir" => $newimages ?? ''
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
    print_r($_POST);
    print_r($dbc->getQuery());
    exit;
    echo $ex->getMessage();
}
exit;
