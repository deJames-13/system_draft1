<?php
session_start();
$_SESSION['currentItemID'] = null;

require_once "../scripts/db-config.php";



?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>DEH Tech Shop</title>


  <?php require_once "../scripts/links.php" ?>

</head>

<body class="relative text-accent">
  <!-- Header -->
  <?php include '../components/header.php'; ?>

  <main>

    <!-- Top Bar -->
    <!-- here --> <?php include_once '../components/top-bar.php'; ?>


    <!-- Main Shop -->
    <div class="container flex items-start justify-between mx-auto">

      <!-- Side Bar -->
      <!-- here --> <?php include_once '../components/side-bar.php'; ?>




      <!-- Pages -->
      <!-- here -->
      <?php

      if (isset($_GET['page'])) {
        $page = $_GET['page'];
      } else {
        $page = 'shop';
      }
      switch ($page) {
        case 'shop':
          include_once '../components/products.php';
          break;
        case 'cart':
          include_once '../components/cart.php';
          break;
        case 'orders':
          include_once '../components/orders.php';
          break;

        default:
          include_once '../components/products.php';
          break;
      }


      ?>


    </div>

  </main>

  <!-- Footer -->
  <script src="../js/index.js"></script>

</body>

</html>