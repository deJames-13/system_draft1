<?php
require_once '../scripts/db-config.php';
include_once '../components/modals.php';
session_start();

if (empty($_SESSION['adminId'])) {
    header("Location: ./account/");
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

            <div class="shop-panel-wrapper min-w-[600px] container p-6 mb-8 mx-4 border border-t-2 border-accent rounded-t-xl flex flex-col items-start space-y-6">
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
                        include_once './pages/inventory.php';
                        break;
                    case 'orders':
                        include_once './pages/orders.php';
                        break;
                    case 'employees':
                        include_once './pages/employees.php';
                        break;
                    case 'payroll':
                        include_once './pages/payroll.php';
                        break;

                    default:
                        $_GET['page'] = 'inventory';
                        include_once './pages/inventory.php';
                        break;
                }
                ?>
            </div>

        </div>


    </main>






    <?php
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