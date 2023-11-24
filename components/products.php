<?php

$dbc = new DatabaseConfig();
try {
    $result = $dbc->select(
        tableName: "product",
        columns: [
            "id",
            "item_name",
            "description",
            "price",
            "stock_quantity",
            "image_dir"
        ],
        where: [
            "id" => !empty($_GET['item_id']) && is_numeric($_GET['item_id']) ? $_GET['item_id'] : [">", 0]
        ]
    );
} catch (Exception $e) {
    echo $e->getMessage();
}

?>



<?php if (!empty($_GET['item_id']) && is_numeric($_GET['item_id'])) : ?>


    <?php
    session_start();
    $row = $result[0];
    $itemId = $row['id'];
    $description = $row['description'];
    $itemName = $row['item_name'];
    $itemPrice = $row['price'];
    $itemQuantity = $row['stock_quantity'];
    $itemImage = $row['image_dir'];

    $_SESSION['currentItemID'] = $itemId;
    $isOrder = isset($_GET['type']) && $_GET['type'] == "order" ? 1 : 0;
    $qty = isset($_GET['qty']) ? $_GET['qty'] : 1;
    $tax = 0.12;
    $priceCost = $itemPrice * $qty;
    $subtotal = $priceCost + ($priceCost * $tax);
    $shippingfee = 150;
    $shipdate = date_format(date_add(date_create(date('M d, Y')), date_interval_create_from_date_string("7 days")), 'Y-m-d');
    $total = $subtotal + $shippingfee;
    try {
        $customer = $dbc->select(
            tableName: "customer",
            where: [
                "id" => $_SESSION['userId'],
            ]
        )[0];

        $customerName =  $customer['first_name'] . " " . $customer['middle_name'] . " " . $customer['last_name'];
        $customerAddress = $customer['address'];
    } catch (Exception $e) {
        die;
    }

    ?>

    <!-- CARD LIST CONTAINER -->
    <div class="container p-4 pb-24 px-6 mb-8 mx-4 border border-t-2 border-accent rounded-t-xl flex flex-col items-center space-y-6 lg:items-start ">

        <div class="container  py-4 flex flex-col justify-between items-center lg:flex-row lg:space-x-6 hover:scale-95 transform transition-all">
            <!-- Item Image -->
            <div class="container border border-accent rounded-md h-80 max-w-sm flex items-center justify-between space-x-2 py-8">
                <!-- images container -->
                <?php if (json_decode($itemImage)) : ?>

                    <!-- BTN PREV -->
                    <span id="imagePrev" class="hidden hover:text-secondary hover:scale-110 transform transition-all ">
                        <i class="px-4 fas fa-arrow-left"></i>
                    </span>


                    <!-- IMAGE CONTAIN -->
                    <div id="imageContainer" class="w-full overflow-hidden relative p-3">
                        <?php
                        $images = json_decode($imagePath, true);
                        $c = 0;
                        ?>

                        <div class="slider flex transition-all transform">

                            <?php foreach ($images as $i) : ?>
                                <img src="<?= $i['path'] ?>" alt="<?= $i['name'] ?>" class="object-contain h-full w-full hover:scale[.95] transform transition-all box-border" />

                                <?php $c += 1; ?>
                            <?php endforeach; ?>
                        </div>

                        <?php $c = 0; ?>
                    </div>


                    <!-- BTN NEXT -->
                    <span id="imageNext" class="hidden hover:text-secondary hover:scale-110 transform transition-all ">
                        <i class="px-4 fas fa-arrow-right"></i>
                    </span>


                    <script>
                        $(document).ready(function() {
                            var interval = 3000; // 3 seconds

                            function slideImages() {
                                var container = $('#imageContainer');
                                var slider = container.find('.slider');

                                slider.find('.slide:first').appendTo(slider);
                                slider.css('transform', 'translate(0)');
                            }
                            setInterval(slideImages, interval);
                        });
                    </script>


                <?php else : ?>
                    <img src="<?= $itemImage ?>" alt="" class=" object-contain h-full w-full hover:scale-[.95] transform transition-all" />
                <?php endif; ?>


            </div>

            <!-- Item Info -->
            <div class="container flex flex-col space-y-3 my-3 px-8 lg:my-0 lg:px-0">

                <!-- Name    -->
                <h1 class="text-xl lg:text-4xl">
                    <?= $itemName ?>
                </h1>

                <!-- Price -->
                <div class="flex justify-between">
                    <p class="text-lg lg:text-2xl font-light">Price</p>
                    <p class="text-lg lg:text-2xl font-bold">₱ <?= $itemPrice ?></p>
                </div>

                <!-- Stock -->
                <div class="flex justify-between">
                    <p class="text-lg lg:text-2xl font-light">Stock Available</p>
                    <p class="text-lg lg:text-2xl font-light"><?= $itemQuantity ?></p>
                </div>

                <!-- Tags -->
                <p class="text-sm font-light">
                    Tags: Technology
                </p>

                <!-- Description -->
                <p class="font-light">Description</p>
                <p class="font-light">
                    <?= $description ?>
                </p>

            </div>
        </div>

        <!-- Button  -->
        <div class="container flex flex-col items-end space-y-2 max-w-sm">
            <div class="container flex justify-stretch items-center">

                <!-- Subtract Quantity -->
                <button onclick="setQty(this)" name="subBtn_<?= $itemId ?>" id="subBtn_<?= $itemId ?>" class="container p-2 border border-accent rounded-full hover:bg-secondary50">
                    -
                </button>

                <p id="setQty_<?= $itemId ?>" name="setQty_<?= $itemId ?>" value="1" class="container text-center p-2">1</p>

                <!-- Add Quantity -->
                <button onclick="setQty(this)" name="addBtn_<?= $itemId ?>" id="addBtn_<?= $itemId ?>" class="container p-2 border border-accent rounded-full hover:bg-secondary50">
                    +
                </button>

            </div>

            <!-- Add to cart -->
            <div class="container">
                <button onclick="addToCart(this)" id="addToCart_<?= $itemId ?>" class="container text-center font-semibold rounded-full text-accent border border-accent py-2 hover:text-secondary30 hover:bg-secondary">
                    Add to Cart
                </button>
            </div>


            <!-- Make Purchase -->
            <div class="container">
                <button name="singleOrder" id="singleOrder_<?= $itemId ?>" onclick="toggleModal(this)" class="container text-center font-semibold rounded-full bg-primary50 text-accent border border-accent py-2 hover:text-secondary30 hover:bg-secondary">
                    Make Purchase
                </button>
            </div>

            <br /><br />
        </div>
    </div>


    <!-- Make an Order -->
    <!-- Order Modal -->
    <?php if ($isOrder) : ?>

        <div class="fixed z-10 top-0 w-full left-0  overflow-y-auto" id="modal">
            <div class="flex items-center justify-center h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

                <div class="fixed inset-0 transition-opacity">
                    <div class="absolute inset-0 bg-gray-900 opacity-20" />
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">
                    &#8203;
                </span>

                <div class="h-full inline-block align-center overflow-y-auto py-2 transform transition-all align-middle w-full max-w-xl" role="dialog" aria-modal="true" aria-labelledby="modal-headline">

                    <form method="post" action="./order_add.php" class="animate-fall container flex flex-col justify-between rounded-lg overflow-y-auto shadow-xl h-full border border-accent30 bg-white pt-4">
                        <h1 class="text-xl pb-4 font-bold text-accent border-b-2 md:text-3xl">
                            Create an Order
                        </h1>

                        <div class="h-full py-3 px-6 text-lef flex flex-col justify-between">
                            <!-- Order Details -->
                            <div>
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

                                <!-- Item ID -->
                                <div class="flex justify-between items-center">
                                    <p class="text-sm font-light">
                                        Item ID
                                    </p>
                                    <h1 class="text-md font-bold">
                                        #<?= $itemId ?>
                                    </h1>
                                </div>

                                <!-- Item Name -->
                                <div class="flex justify-between items-center">
                                    <p class="text-sm font-light">
                                        Name
                                    </p>
                                    <h1 class="text-lg">
                                        <?= $itemName ?>
                                    </h1>
                                </div>

                                <!-- Price -->
                                <div class="flex justify-between items-center">
                                    <p class="text-sm font-light">
                                        Price
                                    </p>
                                    <h1 class="text-md">
                                        ₱ <?= $itemPrice ?>
                                    </h1>
                                </div>

                                <!-- Quantity -->
                                <div class="flex justify-between items-center">
                                    <p class="text-sm font-light">
                                        Qty
                                    </p>
                                    <h1 class="text-md">
                                        <?= $qty ?>
                                    </h1>
                                </div>

                                <div class="my-2 text-left">
                                    <p class="self-start text-sm font-light"> Choose shipping mode: </p>

                                    <div class="flex items-center space-x-8 px-4 p-2">

                                        <!-- Standard -->
                                        <div id="std" onclick="setShipMode(this)" class="flex  space-x-4 items-center cursor-pointer">
                                            <div name="chkstd" id="chkStd" class=" chkChecked bg-primary border-b-2 flex items-center justify-center w-6 h-6 aspect-square border border-accent rounded hover:transform hover:transition-all hover:bg-secondary "><i class="fas fa-check"></i></div>
                                            <span class="text-sm font-md border-accent hover:transform hover:transition-all hover:border-b-2 cursor-pointer">Standard</span>
                                        </div>

                                        <!-- Express -->
                                        <div id="exp" onclick="setShipMode(this)" class="flex space-x-4 items-center cursor-pointer">
                                            <div name="chkexp" id="chkExp" class=" w-6 h-6 flex items-center justify-center aspect-square border border-accent rounded hover:transform hover:transition-all hover:bg-secondary "><i class="hidden fas fa-check"></i></div>
                                            <span class="text-sm font-md border-accent hover:transform hover:transition-all hover:border-b-2 cursor-pointer">Express</span>
                                        </div>

                                        <!-- Priority -->
                                        <div id="prt" onclick="setShipMode(this)" class="flex space-x-4 items-center cursor-pointer">
                                            <div name="chkprt" id="chkPrt" class=" w-6 h-6 aspect-square border border-accent flex items-center justify-center rounded hover:transform hover:transition-all hover:bg-secondary "><i class="hidden fas fa-check"></i></div>
                                            <span class="text-sm font-md border-accent hover:transform hover:transition-all hover:border-b-2 cursor-pointer">Priority</span>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- Cost Summary -->
                            <div class="flex flex-col space-y-2">

                                <div class="h-[0.1rem] bg-accent"></div>
                                <!-- Price Cost -->
                                <div class="flex justify-between items-center">
                                    <p class="text-sm font-light">
                                        Price Cost
                                    </p>
                                    <h1 class="text-md">
                                        ₱ <?= $priceCost ?>
                                    </h1>
                                </div>
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
                                        ₱ <span id="accsubtotal"><?= $subtotal ?></span>
                                    </h1>
                                </div>
                                <!-- Shipping Fee -->
                                <div class="flex justify-between items-center">
                                    <p class="text-sm font-light">
                                        Shipping Fee
                                    </p>
                                    <h1 class="text-md">
                                        ₱ <span id="shippingfee"><?= $shippingfee ?></span>
                                    </h1>
                                </div>
                                <!-- Total -->
                                <div class="flex justify-between items-center">
                                    <p class="text-lg font-bold">
                                        Total
                                    </p>
                                    <h1 class="text-lg font-bold">
                                        ₱ <span id="txtTotal"><?= $total ?></span>
                                    </h1>
                                </div>
                            </div>

                        </div>

                        <input type="hidden" name="productId" value="<?= $itemId ?>">
                        <input type="hidden" name="quantity" value="<?= $qty ?>">
                        <input type="hidden" name="subtotal" id="subtotal" value="<?= $subtotal ?>">
                        <input type="hidden" name="shippingType" id="shippingType" value="Standard">
                        <input type="hidden" name="totalCost" id="totalCost" value="<?= $total ?>">


                        <!-- BUTTONS -->
                        <div class="bg-gray-200 px-4 py-3 text-right ">

                            <a href="./?item_id=<?= $itemId ?>" type="button" class="py-2 px-4 border border-red-600 rounded hover:bg-red-300 mr-2" name="closeModal" id="closeModal_<?= $itemId ?>"><i class=" fas fa-times"></i> Cancel</a>

                            <button type="submit" class="py-2 px-4 bg-primary rounded hover:bg-blue-400 hover:text-accent mr-2"><i class="fas fa-check"></i> Confirm</button>
                        </div>

                    </form>


                </div>
            </div>
        </div>
    <?php endif; ?>


<?php else : ?>


    <!-- CARD LIST CONTAINER -->
    <div class="max-h-screen container p-4 grid grid-col-1 gap-5 pb-24 mb-8 mx-4 border border-t-2 border-accent place-items-start overflow-scroll rounded-t-xl md:grid-cols-3 lg:grid-cols-4">

        <?php foreach ($result as $row) : ?>
            <?php
            $itemId = $row['id'];
            $itemName = $row['item_name'];
            $itemPrice = $row['price'];
            $itemQuantity = $row['stock_quantity'];
            $itemImage = $row['image_dir'];

            ?>

            <div id="item_<?= $itemId ?>" class="w-full bg-primary10 border border-accent rounded-lg hover:bg-primary30 hover:border-2 hover:scale-105 transform transition-all">

                <!-- Image -->
                <div id="itemImg_<?= $itemId ?>" onclick=" cardClicked(this)" class="my-4 h-32 border bg-contain bg-white bg-no-repeat bg-center " style="background-image: url('<?= $itemImage ?>')">
                </div>

                <div class="mx-4 pb-4">
                    <!-- Product Info -->

                    <div id="itemInfo_<?= $itemId ?>" onclick="cardClicked(this)">
                        <h1 class="overflow-auto scroll whitespace-nowrap text-1xl text-bold text-accent hover:text-secondary">
                            <?= $itemName  ?>
                        </h1>
                        <h2 class="text-lg">
                            ₱<?= $itemPrice ?>
                        </h2>
                        <h3 class="text-sm">
                            <span class="fontlight">Stock: </span><?= $itemQuantity ?>
                        </h3>
                    </div>

                    <!-- Actions -->
                    <div class="my-2 flex items-end space-x-4 md:justify-between">
                        <div class="flex items-center justify-start space-x-4">

                            <!-- Subtract Qty -->
                            <button onclick="setQty(this)" name="subBtn_<?= $itemId ?>" id="subBtn_<?= $itemId ?>" class="px-1 border border-accent hover:bg-secondary50">
                                <i class="fas fa-minus"></i>
                            </button>

                            <!-- Card Qty -->
                            <span name="setQty_<?= $itemId ?>" id="setQty_<?= $itemId ?>">1</span>

                            <!-- Add Qty -->
                            <button onclick="setQty(this)" name="addBtn_<?= $itemId ?>" id="addBtn_<?= $itemId ?>" class="px-1 border border-accent hover:bg-secondary50">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <div>
                            <!-- Add to Cart -->
                            <button onclick="addToCart(this)" id="addToCart_<?= $itemId ?>" class="p-2 border-accent hover:bg-secondary50 h-10 w-10 border">
                                <i class="fas fa-cart-shopping"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>



<?php endif; ?>