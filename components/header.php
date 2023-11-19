<?php
session_start();
?>

<header>
  <nav class="relative mx-auto p-4 drop-shadow-md">
    <div class="flex items-center justify-between">
      <a class="pt-2" href="../home">
        <img src="../img/deh-logo.png" alt="deh-logo" class="h-20" />
      </a>

      <div class="hidden space-x-8 p-2 items-center md:flex">
        <a href="../home/" class="text-accent hover:text-secondary"> Home </a>


        <a href="../shop/" class="text-accent hover:text-secondary"> Products </a>

        <?php if ($_SESSION['userId']) : ?>
          <div class="cursor-pointer flex space-x-2 items-center justify-center px-6 rounded-full bg-secondary75 p-2">
            <a href="../account/profile.php?viewprofile=1" id="nav-cta" class="text-accent hover:text-white ">
              <i class="fas fa-user"></i>
            </a>
          </div>
        <?php else : ?>
          <a href="../account/signup.php" id="nav-cta" class="text-accent hover:text-white px-6 rounded-full bg-secondary75 p-2">
            Sign Up
          </a>
        <?php endif; ?>
      </div>
    </div>
  </nav>
</header>