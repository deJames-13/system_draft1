<?php
// show error
// echo '<pre>';
// print_r($_POST);
// echo '</pre>';
// exit;

session_start();
require_once '../../scripts/db-config.php';
require_once '../../scripts/handle-images.php';

// error_reporting(E_ALL);
try {
    $dbc = new DatabaseConfig();
    $id = $_POST['id'];
    $currimages = $dbc->select('user', ['image_dir'], ['id' => $id])[0]['image_dir'];

    $newimages = handleImageUpload('../../img/user', $_FILES['images']);
    if (json_decode($currimages)) {
        $images = $newimages ? array_merge(json_decode($currimages, true), json_decode($newimages, true)) : json_decode($currimages, true);
        $newimages = json_encode($images);
    } else if (file_exists($currimages)) {
        unlink("$currimages");
    }

    // check username availability
    $username = $dbc->select('user', ['username'], ['id' => $id])[0]['username'];

    if ($username != $_POST['username']) {
        $res = $dbc->select('user', ['username'], ['username' => $_POST['username']]);
        if (!empty($res)) {
            header("Location: ../?page=employees&id=$id&res=usernameexists");
            exit;
        }
    }

    $res = $dbc->update_into(
        'user',
        [
            'first_name' => $_POST['first_name'],
            'middle_name' => $_POST['middle_name'],
            'last_name' => $_POST['last_name'],
            'username' => $_POST['username'],
            'email' => $_POST['email'],
            'role_id' => $_POST['role'],
            'department_id' => $_POST['department'],
            'address' => $_POST['address'],
            'phone_number' => $_POST['phone_number'],
            'birthdate' => $_POST['birthdate'],
            'age' => $_POST['age'],
            'image_dir' => $newimages ?? ''
        ],
        [
            'id' => $id
        ]
    );

    if ($res) {
        $_SESSION['adminUser'] = $_POST['username'];
        $_SESSION['userRoleId'] = $_POST['role'];

        header("Location: ../?page=employees&id=$id&res=employeeupdatesuccess");
    } else {
        header("Location: ../?page=employees&id=$id&res=employeeupdateerror");
    }
    exit;
} catch (Exception $ex) {
    echo $ex->getMessage();
}
// header('Location: ../');
// exit;
