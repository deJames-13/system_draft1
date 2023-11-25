
<?php
session_start();


if (!isset($_SESSION['adminId'])) {
    header("Location: ../?page=login&res=notloggedin");
    exit();
}


if (!isset($_POST['username']) || !isset($_POST['hoursWorked']) || !isset($_POST['payGrade'])) {
    header("Location: ../?page=payroll&res=invalidinput");
    exit();
}

require_once "config.php";

$username = $_POST['username'];
$hw = $_POST['hoursWorked'];
$pg = $_POST['payGrade'];



try {

    // get max salary id 
    $sql = "SELECT MAX(id) AS max_id FROM salary;";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $id = $row['max_id'] + 1;

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
    if ($result) {
        header("Location: ./update.php?id=$id");
    } else {
        header("Location: ../?page=payroll&res=payrolladdfailed");
    }
    exit();
} catch (Exception $th) {
    echo $th->getMessage();
}




?>
        