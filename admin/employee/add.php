<?php

session_start();

if (!isset($_SESSION['adminId']) || empty($_POST['action']) || $_SESSION['userRoleId'] == 4) {
    header('Location: ../');
}

require_once '../../scripts/db-config.php';
require_once '../../scripts/handle-images.php';

try {



    $dbc = new DatabaseConfig();


    // check username availability
    $username = $dbc->select('user', ['username'], ['id' => $id])[0]['username'];
    if ($username != $_POST['username']) {
        $res = $dbc->select('user', ['username'], ['username' => $_POST['username']]);
        if (!empty($res)) {
            header("Location: ../?page=employees&id=$id&res=usernameexists");
            exit;
        }
    }


    $images = handleImageUpload('../../img/user', $_FILES['images']);
    $res = $dbc->insert_into(
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
            'image_dir' => $images ?? ''
        ]
    );

    // insert in login table
    $res = $dbc->insert_into(
        'login',
        [
            'id' => $dbc->getConnection()->insert_id,
            'username' => $_POST['username'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
        ]
    );



    if ($res) {
        header('Location: ../?page=employees&res=employeecreatesuccess');
    } else {
        header('Location: ../?page=employees&res=employeeadderror');
    }
    exit;
} catch (Exception $th) {
    echo $dbc->getQuery();
    echo $th->getMessage();
    throw $th;
}
