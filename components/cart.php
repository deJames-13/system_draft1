<?php

$userName = isset($_SESSION['userName']) ? $_SESSION['userName'] : null;
$customerId = isset($_SESSION['userID']) ? $_SESSION['userID'] : null;

$query = <<<SQL
SELECT 
    c.id,
    c.customer_id,
    CONCAT(cust.first_name, ' ', cust.last_name) as customer_name,
    cust.address,
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

<!-- CART LIST -->

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
                            <p class="text-md font-semibold">Total: ₱ <strong><?= $total ?></strong></p>
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
                    <div onclick="checkCart(this)" name="btnCartCheck_<?= $id ?>" id="btnCartCheck_<?= $id ?>" class="flex items-center justify-center w-full h-full p-4 border-l border-t border-accent rounded-br-md lg:rounded-b-none lg:rounded-tr-md lg:border-t-0  hover:bg-green-400 ">
                        <i class="fas fa-check "></i>
                    </div>
                    <div id="btnShow_<?= $id ?>" onclick="swapCardAction(this)" class="w-full h-full p-4 flex justify-center items-center rounded-bl-md border-t border-accent lg:border-l lg:rounded-b-none lg:rounded-br-md hover:bg-blue-400">
                        <i class="fas fa-pen"></i>
                    </div>
                </div>
                <div class="menu-hidden flex items-center justify-around lg:flex-col">
                    <div id="btnHideAndUpdate_<?= $id ?>" onclick="swapCardAction(this)" class="flex items-center justify-center w-full h-full border-t rounded-bl-md  border-accent p-4 lg:rounded-b-none lg-border-t-0 lg:rounded-tr-md lg:border-l hover:bg-blue-300">
                        <i class="hidden fas fa-angle-right lg:block hover:bg-blue-300"></i>
                        <i class="fas fa-angle-down lg:hidden hover:bg-blue-300"></i>
                    </div>
                    <a href="./?page=cart&res=confirmdelete&id=<?= $itemId ?>" class="flex items-center justify-center w-full h-full border-t border-l border-accent p-4 rounded-br-md lg:rounded-b-none lg:rounded-br-md  hover:bg-red-300">
                        <i class="fas fa-trash hover:text-red-600"></i>
                    </a>
                </div>
            </div>
        </div>

    <?php endforeach; ?>

    <br /><br />
</div>

<!-- /// -->


<!-- CART CHECK OUT MODAL -->

<?php if ($_GET['ids']) : ?>

    <?php
    $customerName = $result[0]['customer_name'];
    $customerAddress = $result[0]['address'];
    $ids = explode(',', $_GET['ids']);
    $selected_cart_ids = [];
    $items = [];
    $_SESSION['selected_cart_items'] = [];
    foreach ($result as $row) {
        if (array_search($row['id'], $ids) > -1) {
            array_push($selected_cart_ids, $row['id']);
            array_push($items, $row);
            array_push($_SESSION['selected_cart_items'], $row);
        }
    }
    $post_ids = implode(",", $selected_cart_ids);
    $accSubTotal;
    ?>

    <!-- Modal -->

    <div class="fixed z-10 top-0 w-full left-0  overflow-y-auto" id="modal">
        <div class="flex items-center justify-center h-screen py-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-900 opacity-20" />
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">
                &#8203;
            </span>

            <div class="h-full inline-block align-center pt-4 transform transition-all align-middle w-full max-w-2xl" role="dialog" aria-modal="true" aria-labelledby="modal-headline">

                <form action="./cart_checkout.php" method="post" class="animate-fall relative container flex flex-col space-y-2 rounded-lg overflow-y-auto h-full shadow-xl border border-accent30 bg-white pt-4">

                    <div class="flex px-4 pb-4 items-center justify-between border-b-2">
                        <h1 class="text-xl font-bold text-accent md:text-3xl">
                            Order Check Out
                        </h1>
                        <a class="px-2 rounded border-red-600 border hover:bg-red-300 mr-2" href="./?page=cart" name="closeModal" id="closeModal_<?= $itemId ?>"><i class=" fas fa-times"></i></a>
                    </div>

                    <div class="py-3 px-6 text-left flex flex-col space-y-4">
                        <!-- Order Details -->
                        <!-- Customer Info -->
                        <div class="flex justify-between items-center">
                            <p class="text-sm font-light">
                                Name: <?= $customerName ?>
                            </p>

                            <!-- Order Date -->
                            <p class="text-sm font-light">
                                Order Date: <strong><?php echo date('M d, Y') ?></strong>
                            </p>
                        </div>
                        <div class="flex flex-col items-start my-2">
                            <p class="text-sm font-light">
                                Shipping Address:
                                <br>
                            </p>
                            <textarea type="text" class="text-sm w-full items-start px-0 font-light resize-none" name="shipAddr" id="shipAddr" value="<?= $customerAddress ?>"><?= $customerAddress ?></textarea>
                        </div>

                        <h1 class="font-bold">Products Ordered</h1>

                        <div class="container max-h-60 overflow-y-scroll flex flex-col space-y-2">

                            <div class="hidden sm:grid sm:grid-cols-4 gap-5 text-left border-b-2 border-accent">
                                <!-- Item ID -->
                                <h1 class="text-md font-light">
                                </h1>

                                <!-- Item Name -->
                                <h1 class="text-md">
                                    Name
                                </h1>
                                <!-- Price -->
                                <p>
                                    Price
                                </p>
                                <!-- Qty -->
                                <p>
                                    Qty
                                </p>
                            </div>
                            <?php foreach ($items as $i => $row) : ?>
                                <?php
                                $itemId = $row['product_id'];
                                $itemName = $row['item_name'];
                                $itemPrice = $row['price'];
                                $itemQuantity = $row['quantity'];
                                $itemImage = $row['image_dir'];
                                $priceCost = $itemPrice * $itemQuantity;
                                $subtotal = $priceCost + ($priceCost  * $tax);
                                $_SESSION['selected_cart_items'][$i]['total_cost'] = $subtotal;
                                $accSubTotal += $subtotal;

                                ?>

                                <div class="grid sm:grid-cols-4 sm:gap-5 text-left ">
                                    <!-- Item ID -->
                                    <h1 class="text-md font-light">
                                        <strong>Item #<?= $itemId ?></strong>
                                    </h1>

                                    <!-- Item Name -->
                                    <h1 class="text-md">
                                        <?= $itemName ?>
                                    </h1>
                                    <!-- Price -->
                                    <p>
                                        ₱ <?= $itemPrice ?>
                                    </p>
                                    <!-- Qty -->
                                    <p>
                                        x<?= $itemQuantity ?>
                                    </p>
                                </div>

                                <hr>
                            <?php endforeach; ?>
                        </div>


                        <!-- Shipping -->
                        <div class="my-2 text-left">
                            <p class="self-start text-sm font-light"> Choose shipping mode: </p>

                            <div class="flex items-center space-x-8 px-4 p-2">

                                <div id="std" onclick="setShipMode(this)" class="flex  space-x-4 items-center cursor-pointer">
                                    <div name="chkstd" id="chkStd" class=" chkChecked bg-primary border-b-2 flex items-center justify-center w-6 h-6 aspect-square border border-accent rounded hover:transform hover:transition-all hover:bg-secondary "><i class="fas fa-check"></i></div>
                                    <span class="text-sm font-md border-accent hover:transform hover:transition-all hover:border-b-2 cursor-pointer">Standard</span>
                                </div>

                                <div id="exp" onclick="setShipMode(this)" class="flex space-x-4 items-center cursor-pointer">
                                    <div name="chkexp" id="chkExp" class=" w-6 h-6 flex items-center justify-center aspect-square border border-accent rounded hover:transform hover:transition-all hover:bg-secondary "><i class="hidden fas fa-check"></i></div>
                                    <span class="text-sm font-md border-accent hover:transform hover:transition-all hover:border-b-2 cursor-pointer">Express</span>
                                </div>
                                <div id="prt" onclick="setShipMode(this)" class="flex space-x-4 items-center cursor-pointer">
                                    <div name="chkprt" id="chkPrt" class=" w-6 h-6 aspect-square border border-accent flex items-center justify-center rounded hover:transform hover:transition-all hover:bg-secondary "><i class="hidden fas fa-check"></i></div>
                                    <span class="text-sm font-md border-accent hover:transform hover:transition-all hover:border-b-2 cursor-pointer">Priority</span>
                                </div>
                            </div>
                        </div>

                        <!-- Cost Summary -->
                        <div class="flex flex-col space-y-2">

                            <div class="h-[0.1rem] bg-accent"></div>
                            <!-- VAT -->
                            <div class="flex justify-between items-center">
                                <p class="text-sm font-light">
                                    VAT
                                </p>
                                <h1 class="text-md">
                                    <?= $tax * 100 ?>%
                                </h1>
                            </div>
                            <!-- Sub Total -->
                            <div class="flex justify-between items-center">
                                <p class="text-sm font-light">
                                    Sub Total
                                </p>
                                <h1 class="text-md">
                                    ₱ <span id="accsubtotal"><?= $accSubTotal ?></span>
                                </h1>
                            </div>
                            <!-- Shipping Fee -->
                            <div class="flex justify-between items-center">
                                <p class="text-sm font-light">
                                    Shipping Fee
                                </p>
                                <h1 class="text-md">
                                    ₱ <span id="shippingfee"><?= $shippingfee ?? 150 ?></span>
                                </h1>
                            </div>
                            <!-- Total -->
                            <div class="flex justify-between items-center">
                                <p class="text-lg font-bold">
                                    Total
                                </p>
                                <?php
                                $total = $accSubTotal + ($shippingfee ?? 150);
                                ?>
                                <h1 class="text-lg font-bold">
                                    ₱ <span id="txtTotal"><?= $total ?></span>
                                </h1>
                            </div>
                        </div>

                    </div>

                    <!-- Inputs for Form -->
                    <input type="hidden" name="selected_cart_ids" value="<?= $post_ids ?>">
                    <input type="hidden" name="shippingType" id="shippingType" value="Standard">
                    <input type="hidden" name="subtotal" id="subtotal" value="<?= $accSubTotal ?>">
                    <input type="hidden" name="totalCost" id="totalCost" value="<?= $total ?>">

                    <!-- BUTTONS -->
                    <div class="bg-opacity-80 border-t border-accent rounded-b-md w-full bg-gray-200 md:px-4 py-3 text-right ">
                        <a class="cursor-pointer py-2 px-4 border border-red-600 rounded hover:bg-red-300 mr-2" href="./?page=cart"><i class=" fas fa-times"></i> Cancel Order</a>

                        <button type="submit" name="cartCreateOrder_<?= $id ?>" id="cartCreateOrder_<?= $id ?>" class="py-2 px-4 bg-primary rounded hover:bg-blue-400 hover:text-accent mr-2"><i class="fas fa-check"></i> Create Order</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- /// -->

<?php endif; ?>