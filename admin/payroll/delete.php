<?php
require_once "config.php";

$id = $_GET['id'];


$sql = "DELETE uhs
            FROM user_has_salary AS uhs
            JOIN user AS u ON u.id = uhs.user_id
            WHERE uhs.salary_id = $id;";

$sql2 = "DELETE FROM benefits
            WHERE id = $id;";

$sql3 = "DELETE FROM salary
            WHERE id = $id;";

$result = $conn->query($sql);
$result2 = $conn->query($sql2);
$result3 = $conn->query($sql3);

header("Location: ../?page=payroll&res=deleteitemsuccess");
