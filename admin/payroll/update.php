<?php
require_once "config.php";

$sql = "UPDATE salary AS s
            JOIN user_has_salary AS uhs ON s.id = uhs.salary_id
            JOIN user AS u ON u.id = uhs.user_id
            SET s.gross_amount = uhs.payGrade * s.hoursWorked;";

$sql2 = "UPDATE benefits AS b
            JOIN salary AS s ON s.benefits_id = b.id
            SET b.philHealth = 0.04 * s.gross_amount,
            b.sss = 0.045 * s.gross_amount,
            b.pagibig = 0.02 * s.gross_amount ;";

$sql3 = "UPDATE salary  AS s
            JOIN benefits AS b ON s.benefits_id = b.id
            SET s.net_amount = s.gross_amount - (b.sss + b.pagIbig + b.philHealth + (s.tax_percentage * s.gross_amount)) ;";

$result = $conn->query($sql);
$result2 = $conn->query($sql2);
$result3 = $conn->query($sql3);

header("Location: ../?page=payroll");
