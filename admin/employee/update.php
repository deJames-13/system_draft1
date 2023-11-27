<?php
session_start();
if (!isset($_SESSION['adminId']) || empty($_POST['action']) || $_SESSION['userRoleId'] == 4) {
    header('Location: ../');
}
require_once '../../scripts/db-config.php';
require_once '../../scripts/handle-images.php';

try {
    $dbc = new DatabaseConfig();
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $action = isset($_POST['action']) ? $_POST['action'] : null;

    if ($action == 'updatepassword') {

        $user = $dbc->select('login', ["username, password"], ['id' => $id]);


        // check if current pass is correct
        if (!password_verify($_POST['prev_password'], $user[0]['password'])) {
            header("Location: ../?page=employees&id=$id&&mode=edit&changepass=1&res=incorrectpassword");
            exit;
        }

        // check if new pass matches confirm pass
        if ($_POST['password'] != $_POST['confpass']) {
            header("Location: ../?page=employees&id=$id&&mode=edit&changepass=1&res=passwordmismatch");
            exit;
        }


        $res = $dbc->update_into(
            tableName: 'login',
            data: ['password' => password_hash($_POST['password'], PASSWORD_DEFAULT)],
            where: ['id' => $id]
        );

        if ($res) {
            header("Location: ../?page=employees&id=$id&res=passwordupdatesuccess");
        } else {
            header("Location: ../?page=employees&id=$id&res=passwordupdateerror");
        }
        exit;
    } else {
        // IMAGE UPLOAD
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

        $birthdate = date('Y-m-d', strtotime($_POST['birthdate']));
        $currentDate = date('Y-m-d');
        $age = date_diff(date_create($birthdate), date_create($currentDate))->y;
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
                'birthdate' => $birthdate,
                'age' => $age,
                'image_dir' => $newimages ?? ''
            ],
            [
                'id' => $id
            ]
        );
    }



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
