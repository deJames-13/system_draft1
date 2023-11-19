<?php
session_start();

if (empty($_SESSION['adminId'])) {
    header("./account");
    exit;
}

if (!empty($_GET['fromLogout']) && $_GET['fromLogout'] == '1') {
    session_destroy();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>

    <?php require_once '../scripts/links.php' ?>


</head>

<body>

    <?php include_once './components/header.php' ?>

    <main>
        <!-- Top Bar -->
        <!-- here --> <?php include_once '../components/top-bar.php'; ?>


        <!-- Main Content -->
        <div class="container flex items-start justify-between mx-auto">



            <!-- Side Bar -->
            <!-- here --> <?php include_once './components/side-bar.php'; ?>


            <!-- Pages -->
            <!-- here -->
            <?php

            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = 'inventory';
            }
            switch ($page) {
                case 'inventory':
                    break;
                case 'orders':
                    break;
                case 'employees':
                    break;
                case 'payroll':
                    break;

                default:
                    break;
            }


            ?>
        </div>


    </main>






    <?php include_once '../components/modals.php';
    switch ($_GET['res']) {
        case 'loginsuccess':
            echo createModal(
                title: "Login Success.",
                message: "Welcome! Your account has successfully login.",
                visible: true
            );
            break;
        default:
            break;
    }
    ?>
    <script src="../js/index.js"></script>
</body>

</html>