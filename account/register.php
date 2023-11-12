<?php
session_start();

if (!empty($_GET['fromLogout']) && $_GET['fromLogout'] == '1') {
    session_destroy();
}

if (!empty($_SESSION['userName'])) {
    header('Location: ../home/');
}

if ($_POST['action'] == 'signup') {

    $isValidPass = $_POST['password'] == $_POST['confirmPass'];

    if (!$isValidPass) {
        header('Location: ./signup.php?error=incorrectpassword');
        exit;
    }

    $_SESSION['newUser'] = [
        'username' => $_POST['username'],
        'email' => $_POST['email'],
        'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
    ];
    header('Location: ./profile.php');
    exit;
} else if ($_POST['action'] == 'saveprofile') {
    require_once '../scripts/db-config.php';

    $userAddr = $_POST['street_address'] . ', ' . $_POST['region'] . ', ' .  $_POST['country'] . ', ' . $_POST['zip_code'];
    $birthdate = date('Y-m-d', strtotime($_POST['birthdate']));

    $dbc = new DatabaseConfig();
    $res = $dbc->insert_into(
        tableName: "customer",
        data: [

            "username" => $_SESSION['newUser']['username'],
            "email" => $_SESSION['newUser']['email'],
            "password" => $_SESSION['newUser']['password'],
            "first_name" => $_POST['first_name'],
            "last_name" => $_POST['last_name'],
            "middle_name" => $_POST['middle_name'],
            "phone_number" => $_POST['phone_number'],
            "address" => $userAddr,
            "birthdate" => $birthdate,
            "age" => $_POST['age']
        ]
    );
    if ($res) {
        $_SESSION['userId'] = $dbc->getConnection()->insert_id;
        $_SESSION['userName'] = $_SESSION['newUser']['username'];
        header('Location: ../shop/');
        exit;
    } else {
        header('Location: ./signup.php?error=accountcreateerror');
        exit;
    }
}

exit;
