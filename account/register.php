<?php

session_start();

if (!empty($_GET['fromLogout']) && $_GET['fromLogout'] == '1') {
    session_destroy();
}

require_once '../scripts/db-config.php';
require_once '../scripts/handle-images.php';

try {


    $dbc = new DatabaseConfig();
    $id = $_SESSION['userId'];

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
        header('Location: ./profile.php?viewprofile=1&mode=accountsetup');
        exit;
    } else if ($_POST['action'] == 'saveprofile') {

        $userAddr = ($_POST['street_address'] ?? '-') . ', ' . ($_POST['region'] ?? '-') . ', ' . ($_POST['country'] ?? '-')  . ', ' . ($_POST['zipcode'] ?? '-');

        $birthdate = date('Y-m-d', strtotime($_POST['birthdate']));
        $images = handleImageUpload('../img/customer', $_FILES['images']);
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
                "age" => $_POST['age'],
                "image_dir" => $images ?? ''
            ]
        );
        if ($res) {
            $_SESSION['userId'] = $dbc->getConnection()->insert_id;
            $_SESSION['userName'] = $_SESSION['newUser']['username'];
            unset($_SESSION['newUser']);
            header('Location: ../shop/?res=signinsuccess');
        } else {
            header('Location: ./signup.php?res=accountcreateerror');
        }
        exit;
    } else if ($_POST['action'] == 'updateprofile') {

        // check username availability
        $username = $dbc->select('customer', ['username'], ['id' => $id])[0]['username'];

        if ($username != $_POST['username']) {
            $res = $dbc->select('customer', ['username'], ['username' => $_POST['username']]);

            if (!empty($res)) {
                header("Location: ./profile.php?viewprofile=1&res=usernameexists");
                exit;
            }
        }

        $userAddr = ($_POST['street_address'] ?? '-') . ', ' . ($_POST['region'] ?? '-') . ', ' . ($_POST['country'] ?? '-')  . ', ' . ($_POST['zipcode'] ?? '-');
        $birthdate = date('Y-m-d', strtotime($_POST['birthdate']));
        $currentDate = date('Y-m-d');
        $age = date_diff(date_create($birthdate), date_create($currentDate))->y;


        $currimages = $dbc->select('customer', ['image_dir'], ['id' => $id])[0]['image_dir'];

        $newimages = handleImageUpload('../img/customer', $_FILES['images']);
        if (json_decode($currimages)) {
            $images = $newimages ? array_merge(json_decode($currimages, true), json_decode($newimages, true)) : json_decode($currimages, true);
            $newimages = json_encode($images);
        } else if (file_exists($currimages)) {
            unlink("$currimages");
        }

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
                "age" => $age,
                "image_dir" => $newimages
            ],
            where: [
                "id" => $id
            ]
        );
        if ($res) {

            $_SESSION['userName'] = $_POST['username'];

            header('Location: ./profile.php?viewprofile=1&res=accountupdatesuccess');
        } else {
            header('Location: ./profile.php?viewprofile=1&res=accountupdateerror');
        }
        exit;
    } else if ($_GET['action'] == 'deleteprofile') {

        $image_dir = $dbc->select('customer', ['image_dir'], ['id' => $id])[0]['image_dir'];
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
            tableName: "customer",
            where: [
                "id" => $_SESSION['userId']
            ]
        );

        if ($res) {
            session_destroy();
            header('Location: ./login.php?res=deleteaccountsuccess');
        } else {
            header('Location: ./profile.php?viewprofile=1&res=accountdeleteerror');
        }
        exit;
    }
} catch (Exception $ex) {
    echo $dbc->getQuery();
    echo $ex->getMessage();
}
