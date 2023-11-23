<?php

session_start();
if (empty($_SESSION['adminId']) || empty($_POST['action'])) {
    header('Location: ../');
    exit;
}

require_once '../../scripts/db-config.php';

try {
    $dbc = new DatabaseConfig();

    // create new user
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
