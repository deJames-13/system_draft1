<?php
echo '<pre>';
print_r($_POST);
print_r($_FILES);
echo '</pre>';
exit;


// [action] => update
// [id] => 34
// [first_name] => James
// [middle_name] => M
// [last_name] => theDev
// [username] => dev
// [email] => dejames@gmail.com
// [role] => 1
// [department] => 1
// [address] => 123 lane, San Pedro, Laguna, 4023, Philippines
// [phone_number] => 0999999999
// [birthdate] => 2004-03-12
// [age] => 19

require_once '../../scripts/db-config.php';

try {
    $dbc = new DatabaseConfig();

    $res = $dbc->update_into(
        'employee',
        [
            'first_name' => $_POST['first_name'],
            'middle_name' => $_POST['middle_name'],
            'last_name' => $_POST['last_name'],
            'username' => $_POST['username'],
            'email' => $_POST['email'],
            'role' => $_POST['role'],
            'department' => $_POST['department'],
            'address' => $_POST['address'],
            'phone_number' => $_POST['phone_number'],
            'birthdate' => $_POST['birthdate'],
            'age' => $_POST['age'],
        ],
        [
            'id' => $_POST['id']
        ]
    );

    if ($res) {
        header('Location: ../?page=employees&res=employeeupdatesuccess.');
    } else {
        header('Location: ../?page=employees&res=employeeupdateerror');
    }
    exit;
} catch (Exception $ex) {
    $ex->getMessage();
}
header('Location: ../');
exit;
