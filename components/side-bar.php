<?php

$isUser = isset($_SESSION['userId']);

if (isset($_GET['page'])) {
  $page = $_GET['page'];
} else {
  $page = 'shop';
}

$active = 'border-b-2 drop-shadow-md bg-secondary30';
$inactive = 'bg-primary30';


?>


<!-- Side Bar -->
<div class="h-screen container mx-2 mb-8 bg-primary10 border py-8 pl-5 rounded-xl border-accent border-r-2 w-20 md:w-auto">
  <div class="h-full flex flex-col justify-between items-end space-y-8">
    <div class="flex flex-col items-center space-y-8">

      <!-- shop [ACTIVE] -->
      <a href="./?page=shop" class=" <?php echo $page == 'shop' ? 'border-b-2 drop-shadow-md bg-secondary30' : 'bg-primary30' ?> text-accent border-accent container p-4 pl-4 rounded-l-full  hover:drop-shadow-lg hover:border md:flex md:items-center md:space-x-2 hover:scale-105 transform transition-all ">

        <i class="fas fa-shop"></i>
        <span class="hidden md:block"> shop </span>

      </a>

      <!-- Cart -->

      <?php if ($isUser) : ?>
        <a href="./?page=cart" class=" <?php echo $page == 'cart' ? 'border-b-2 drop-shadow-md bg-secondary30' : 'bg-primary30' ?> text-accent container border-accent p-4 pl-4 bg-primary30 rounded-l-full md:flex md:items-center md:space-x-2 hover:drop-shadow-lg hover:border hover:scale-105 transform transition-all ">

          <i class="fas fa-cart-shopping"></i>
          <span class="hidden md:block"> cart </span>

        </a>

        <!-- Orders -->
        <a href="./?page=orders" class="<?php echo $page == 'orders' ? 'border-b-2 drop-shadow-md bg-secondary30' : 'bg-primary30' ?> text-accent container border-accent p-4 pl-4 bg-primary30 rounded-l-full md:flex md:items-center md:space-x-2 hover:drop-shadow-lg hover:border hover:scale-105 transform transition-all ">

          <i class="fas fa-receipt"></i>
          <span class="hidden md:block"> orders </span>

        </a>
      <?php endif; ?>


    </div>

    <!-- Logout -->
    <a href="<?= $isUser ? "../account/login.php?fromLogout=1" : '../account/login.php' ?>" class="text-accent container border-accent p-4 pl-4 bg-primary30 rounded-l-full md:flex md:items-center md:space-x-2 hover:drop-shadow-lg hover:border hover:scale-105 transform transition-all ">

      <i class="fas fa-right-from-bracket"></i>
      <span class=" hidden md:block"> <?= $isUser ? "logout" : 'login' ?> </span>

    </a>
  </div>
</div>