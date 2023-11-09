<?php

$userName = $_SESSION['userName'];
$customerId = $_SESSION['userID'];

$query = <<<SQL
SELECT 
    c.id,
    c.id as cart_id,
    c.customer_id,
    cust.username,
    c.product_id,
    p.item_name,
    p.price,
    c.quantity,
    p.image_dir

    FROM cart as c
    INNER JOIN customer as cust
    ON c.customer_id = cust.id

    INNER JOIN product as p
    ON c.product_id = p.id

    WHERE cust.username = ?
    ORDER BY c.id DESC
    ;

SQL;

try {
    $dbc = new DatabaseConfig();
    $result = $dbc->executeQuery(
        query: $query,
        params: [
            "cust.username" => $userName,
        ]
    );
} catch (Exception $e) {
    echo $e->getMessage();
}



?>


<div class="shop-panel-wrapper container p-6 mb-8 mx-4 border border-t-2 border-accent overflow-scroll rounded-t-xl flex flex-col items-start space-y-6">

    <div class="container border-0 border-b-2 pb-2 text-3xl text-accent flex space-x-3 items-center">

        <div class=" container pb-2  text-accent flex justify-between items-center ">
            <div class="flex space-x-2 items-center">
                <i class="fas fa-cart-shopping"></i>
                <h1 class="cursor-pointer font-bold hover:text-secondary">Your Cart</h1>
            </div>
            <button onclick="checkOutCart(this)" id="btnCheckOut" class="hidden p-2 rounded border-accent text-sm font-semibold bg-primary30 border border-b-2 hover:bg-secondary50">
                Check Out
            </button>
        </div>
    </div>
    <?php foreach ($result as $row) : ?>

        <?php
        $id = $row['id'];
        $itemId = $row['product_id'];
        $itemName = $row['item_name'];
        $itemPrice = $row['price'];
        $itemQuantity = $row['quantity'];
        $itemImage = $row['image_dir'];
        $costPrice = $itemPrice * $itemQuantity;
        $tax = 0.12;
        $total = $costPrice + ($costPrice * $tax);


        ?>

        <!-- Cart -->
        <div class="container grid grid-cols-1 gap-4">
            <div class="border border-accent rounded-md bg-primary10 hover:border-2 hover:bg-primary30 lg:flex lg:space-x-4">

                <!-- Item Image -->
                <div class="container h-32 p-8 flex justify-center items-center bg-white rounded-t-md lg:rounded-tr-none lg:rounded-l-md  lg:h-48 lg:max-w-xs ">
                    <img src="<?= $itemImage ?>" alt="" class=" object-contain h-full w-full" />
                </div>

                <div class="container px-4 py-4 lg:flex  lg:justify-between lg:space-x-4">

                    <!-- Cart Info -->
                    <div class="flex flex-col h-full justify-between">
                        <div class=" grid grid-cols-1 gap-x-4 text-sm font-light md:px-8 lg:px-0 md:grid-cols-2">

                            <!-- Item Name -->
                            <p class="text-ellipsis whitespace-nowrap hidden md:block">Product Name</p>
                            <p> <strong><?= $itemName ?></strong> </p>

                            <!-- Price -->
                            <p class="text-ellipsis whitespace-nowrap hidden md:block">Price</p>
                            <p> ₱ <?= $itemPrice ?> </p>

                            <!-- Item ID -->
                            <p class="text-ellipsis whitespace-nowrap  md:block">Item ID: <?= $itemId ?></p>

                            <!-- Quantity -->
                            <p class="text-ellipsis whitespace-nowrap md:block">Qty: <?= $itemQuantity ?></p>
                        </div>

                        <!-- Total -->
                        <div class="py-4 md:px-8 lg:px-0">
                            <p class="text-md font-semibold">Total: <strong><?= $total ?></strong></p>
                        </div>
                    </div>

                    <!-- Quantity Buttons -->
                    <div id="qtyBtns_<?= $id ?>" class="menu-hidden h-full flex flex-row-reverse justify-around lg:flex-col  items-center">

                        <!-- Plus Qty -->
                        <button onclick="setQty(this)" name="addBtn_<?= $id ?>" id="addBtn_<?= $id ?>" class="border p-2 aspect-square flex items-center justify-center border-accent hover:bg-primary50">
                            <i class="fas fa-plus"></i>
                        </button>
                        <div id="setQty_<?= $id ?>" class="p-2 aspect-square flex items-center justify-center">
                            <p class="text-semibold text-lg">
                                <?= $itemQuantity ?>
                            </p>
                        </div>
                        <!-- Sub Qty -->
                        <button onclick="setQty(this)" name="subBtn_<?= $id ?>" id="subBtn_<?= $id ?>" class="border p-2 aspect-square flex items-center justify-center border-accent hover:bg-primary50">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <!-- Actions -->
                <div class="flex flex-row-reverse items-center justify-around lg:flex-col">
                    <div onclick="checkCart(this)" name="btnCartCheck_<?= $id ?>" id="btnCartCheck_<?= $id ?>" class="flex items-center justify-center w-full h-full p-4 border-l border-t border-accent rounded-br-md lg:rounded-b-none lg:rounded-tr-md lg:border-t-0  hover:bg-primary">
                        <i class="fas fa-check "></i>
                    </div>
                    <div id="btnShow_<?= $id ?>" onclick="swapCardAction(this)" class="w-full h-full p-4 flex justify-center items-center rounded-bl-md border-t border-accent lg:border-l lg:rounded-b-none lg:rounded-br-md hover:bg-secondary30">
                        <i class="fas fa-pen"></i>
                    </div>
                </div>
                <div class="menu-hidden flex items-center justify-around lg:flex-col">
                    <div id="btnHideAndUpdate_<?= $id ?>" onclick="swapCardAction(this)" class="flex items-center justify-center w-full h-full border-t rounded-bl-md  border-accent p-4 lg:rounded-b-none lg-border-t-0 lg:rounded-tr-md lg:border-l hover:bg-blue-300">
                        <i class="hidden fas fa-angle-right lg:block hover:bg-blue-300"></i>
                        <i class="fas fa-angle-down lg:hidden hover:bg-blue-300"></i>
                    </div>
                    <div class="flex items-center justify-center w-full h-full border-t border-l border-accent p-4 rounded-br-md lg:rounded-b-none lg:rounded-br-md  hover:bg-red-300">
                        <i onclick="deleteCart(<?= $itemId ?>)" class="fas fa-trash hover:text-red-600"></i>
                    </div>
                </div>
            </div>
        </div>

    <?php endforeach; ?>

    <br /><br />
</div>