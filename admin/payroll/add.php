
<?php
require_once "config.php";
$username = $_POST['username'];
$id = $_POST['salbe'];
$hw = $_POST['hw'];
$pg = $_POST['pg'];
$success = false;





$sql = "INSERT INTO 
            benefits(id)
            VALUES
            ($id);";

$sql2 = "INSERT INTO
            salary(id, benefits_id, hoursWorked)
            VALUES
            ($id, $id, $hw);";

$sql3 = "INSERT INTO 
            user_has_salary(user_id, salary_id, payGrade, created_at) 
            SELECT u.id, $id , $pg, NOW()
            FROM user AS u
            WHERE u.username = '$username';";

$result = $conn->query($sql);
$result2 = $conn->query($sql2);
$result3 = $conn->query($sql3);




if ($pg > 86.805902777777774) {
    $sql2 = "UPDATE salary
            SET tax_percentage = 0.15
            WHERE id = $id;";

    $result = $conn->query($sql2);
} else {
    $sql2 = "UPDATE salary
            SET tax_percentage = 0
            WHERE id = $id;";

    $result = $conn->query($sql2);
}

header("Location: view.php?");




?>
        