<?php
// print_r($_POST);
// exit;
session_start();

if (!empty($_GET['fromLogout']) && $_GET['fromLogout'] == '1') {
    session_destroy();
}

if (!empty($_SESSION['userName'] && $_GET['viewprofile' != 1])) {
    header('Location: ../home/');
}
if (!empty($_GET['action'])) {
} else if (empty($_POST['action'])) {
    header('Location: ../home/');
    exit;
}

require_once '../scripts/db-config.php';

try {


    $dbc = new DatabaseConfig();

    if ($_POST['action'] == 'signup') {

        $isValidPass = $_POST['password'] == $_POST['confirmPass'];

        if (!$isValidPass) {
            header('Location: ./signup.php?res=incorrectpassword');
            exit;
        }

        $res = $dbc->executeQuery(
            query: "SELECT * FROM customer WHERE username = ? OR email = ?",
            params: [
                $_POST['username'],
                $_POST['email']
            ]
        );

        if (count($res) > 0) {
            header('Location: ./signup.php?res=accountexists');
            exit;
        }

        $_SESSION['newUser'] = [
            'username' => $_POST['username'],
            'email' => $_POST['email'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
        ];
        header('Location: ./profile.php?viewprofile=1');
        exit;
    } else if ($_POST['action'] == 'saveprofile') {

        $userAddr = ($_POST['street_address'] ?? '-') . ', ' . ($_POST['region'] ?? '-') . ', ' . ($_POST['country'] ?? '-')  . ', ' . ($_POST['zipcode'] ?? '-');

        $birthdate = date('Y-m-d', strtotime($_POST['birthdate']));

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
            header('Location: ../shop/?res=signinsuccess');
            exit;
        } else {
            header('Location: ./signup.php?res=accountcreateerror');
            exit;
        }
    } else if ($_POST['action'] == 'updateprofile') {

        $userAddr = ($_POST['street_address'] ?? '-') . ', ' . ($_POST['region'] ?? '-') . ', ' . ($_POST['country'] ?? '-')  . ', ' . ($_POST['zipcode'] ?? '-');

        $birthdate = date('Y-m-d', strtotime($_POST['birthdate']));

        $res = $dbc->update_into(
            tableName: "customer",
            data: [

                "username" => $_POST['username'],
                "email" => $_POST['email'],
                "first_name" => $_POST['first_name'],
                "last_name" => $_POST['last_name'],
                "middle_name" => $_POST['middle_name'],
                "phone_number" => $_POST['phone_number'],
                "address" => $userAddr,
                "birthdate" => $birthdate,
                "age" => $_POST['age']
            ],
            where: [
                "id" => $_SESSION['userId']
            ]
        );
        if ($res) {
            header('Location: ./profile.php?viewprofile=1&res=accountupdatesuccess');
            exit;
        } else {
            header('Location: ./profile.php?viewprofile=1&res=accountupdateerror');
            exit;
        }
    } else if ($_GET['action'] == 'deleteprofile') {

        $res = $dbc->delete_from(
            tableName: "customer",
            where: [
                "id" => $_SESSION['userId']
            ]
        );

        if ($res) {
            session_destroy();
            header('Location: ./login.php?res=deleteaccountsuccess');
            exit;
        } else {
            header('Location: ./profile.php?viewprofile=1&res=accountdeleteerror');
            exit;
        }
    }
} catch (Exception $ex) {
    echo $dbc->getQuery();
    echo $ex->getMessage();
}

exit;
