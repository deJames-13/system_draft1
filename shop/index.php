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
  <?php include_once '../components/header.php'; ?>

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

      <!-- Modals -->
      <?php
      include_once '../components/modals.php';

      switch ($_GET['res']) {
        case 'cartAdded':
          echo createModal(
            title: "Item Added",
            visible: true,
            message: "Item has been added to your cart",
            btnConfirm: "View Cart",
            btnFunc: "window.location.replace('./?page=cart')"
          );
          break;
        case 'confirmdelete':
          $id = $_GET['id'] ?? null;
          echo $id ? createModal(
            title: "Confirm Delete",
            visible: true,
            message: "Are you sure you want to delete this item?",
            btnConfirm: "Delete Item",
            btnFunc: "deleteCart($id)"
          ) : '';
          break;
        case 'cartdeletesuccessfully':

          echo createModal(
            title: "Item deleted successfully.",
            visible: true,
            message: "An item has been deleted from your cart.",
          );
          break;
        case 'cartdeleteunsuccessfully':
          echo createModal(
            title: "Item delete failed.",
            visible: true,
            message: "Failed to remove an item from your cart. Please try again or contact us.",
          );
          break;
        case 'cartcheckoutsuccess':
          echo createModal(
            title: "Checkout successful.",
            visible: true,
            message: "Your order has been successfully placed.",
          );
          break;
        case 'cartcheckouterror':
          echo createModal(
            title: "Checkout failed.",
            visible: true,
            message: "Your order has not been placed. Please try again or contact us.",
          );
          break;
        case 'cartAddError':
          echo createModal(
            title: "Add to cart unsuccessful.",
            visible: true,
            message: "The item has not been able to move to cart. Please try again or contact us.",
            btnConfirm: "View Cart",
            btnFunc: "window.location.replace('./?page=cart')"
          );
          break;
        case 'ordersuccess':
          echo createModal(
            title: "Order Success.",
            visible: true,
            message: "Your order has been successfully added.",
          );
          break;
        case 'orderfailed':
          echo createModal(
            title: "Order Failed.",
            visible: true,
            message: "Your request has failed due to internal error. Please try again or contact us.",
          );
          break;


        case 'order_item_delete_success':
          echo createModal(
            title: "Order Deleted Successfully.",
            visible: true,
            message: "Your order has been successfully deleted.",
          );
          break;
        case 'order_item_delete_failed':
          echo createModal(
            title: "Order Delete Failed.",
            visible: true,
            message: "Failed to remove the order item due to internal error. Please try again or contact us.",
          );
          break;
        case 'order_update_success':
          echo createModal(
            title: "Order Updated Successfully.",
            visible: true,
            message: "Your order has been successfully updated.",
          );
          break;
        case 'confirmordercancel':
          $id = $_GET['id'] ?? null;
          echo $id ? createModal(
            title: "Confirm Delete",
            visible: true,
            message: "Are you sure you want to cancel this order?",
            btnConfirm: "Cancel Order",
            btnFunc: "window.location.replace('./order_delete.php?id=' + $id)"
          ) : '';
          break;
        case 'signinsuccess':
          echo createModal(
            title: "Sign in success.",
            visible: true,
            message: "Thank you for signing in! Welcome to our shop!",
          );
          break;
        case 'usernotfound':
          echo createModal(
            title: "Please Log In.",
            visible: true,
            message: "You are currently not logged in. Please log in to an existing account or sign up!",
            btnConfirm: "Sign up",
            btnFunc: "window.location.replace('../account/')"
          );
          break;
          break;

        default:
          break;
      }

      ?>


    </div>

  </main>

  <!-- Footer -->
  <script src="../js/index.js"></script>

</body>

</html>