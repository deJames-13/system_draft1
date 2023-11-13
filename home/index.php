<?php
require_once "../scripts/db-config.php";

session_start();



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home</title>


    <?php require_once "../scripts/links.php" ?>

</head>

<body class="relative text-accent">
    <!-- Header -->
    <?php include_once '../components/header.php'; ?>

    <main>
        <div class="border border-b-2 py-4 hover:text-secondary">
            <h1 class="text-4xl text-center">Welcome to the home page</h1>
        </div>
        <?php include_once '../components/modals.php'; ?>

    </main>

    <!-- Footer -->
    <script src="../js/index.js"></script>
</body>

</html>