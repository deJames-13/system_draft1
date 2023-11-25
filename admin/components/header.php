<?php
session_start();
$id = $_SESSION['adminId'];

?>

<header>
    <header>
        <nav class="relative mx-auto p-4 drop-shadow-md">
            <div class="flex items-center justify-between">
                <a class="pt-2" href="./">
                    <img src="../img/deh-logo.png" alt="deh-logo" class="h-20" />
                </a>
                <div class="hidden space-x-8 p-2 items-center md:flex">
                    <?php if ($id) : ?>
                        <div class="cursor-pointer flex space-x-2 items-center justify-center px-6 rounded-full bg-secondary75 p-2 hover:scale-105 transform transition-all">
                            <a href="./?page=employees&id=<?= $id ?>" id="nav-cta" class="text-accent hover:text-white ">
                                <i class="fas fa-user"></i>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </header>
</header>