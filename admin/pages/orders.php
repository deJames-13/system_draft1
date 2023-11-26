<?php

$status = isset($_GET['status']) ? $_GET['status'] : null;
$id = isset($_GET['id']) ? $_GET['id'] : null;

$query = <<<SQL
  SELECT
    o.id,
    ohp.order_id,
    ohp.product_id,
    o.customer_id,
    CONCAT(c.first_name, ' ', c.last_name) as customer_name,
    c.address,
    ohp.quantity,
    p.item_name,
    p.stock_quantity,
    p.price,
    ohp.cost,
    p.image_dir,
    o.shipping_type,
    o.ship_date,
    o.create_date,
    s.amount as shipping_fee,
    `o`.`status`

  FROM order_has_product as ohp

  INNER JOIN `order` as o
  ON ohp.order_id = o.id

  INNER JOIN product as p
  ON ohp.product_id = p.id

  INNER JOIN customer as c
  ON o.customer_id = c.id

  INNER JOIN shipping_info as s
  ON o.shipping_type = s.`type`
  
  ORDER BY o.id DESC
SQL;


try {

    $dbc = new DatabaseConfig();

    $orders = $dbc->executeQuery(
        $query
    );
} catch (Exception $ex) {
    echo $ex->getMessage();
}

// Group Result arry
$groupedResult = [];
?>



<div class="flex container flex-col space-y-4 h-full overflow-y-hidden">

    <!-- BUTTONS -->
    <div class="container flex items-center justify-between">
        <h3>Selected Item: <span id="selectedItemId">_</span> </h3>
        <div class="flex justify-end space-x-4 px-4 text-sm">
            <button name="ordership_orders" onclick="btnActionsClicked(this)" class="flex items-center justify-center space-x-2 border border-accent p-2 rounded hover:bg-primary50 hover:border-b-2 hover:shadow-md hover:scale-[.95] transform transition-all">
                <i class="fas fa-boxes-packing">
                </i>
                <span>
                    Ship Order
                </span>
            </button>
            <button name="orderdeliver_orders" onclick="btnActionsClicked(this)" class="flex items-center justify-center space-x-2 border border-accent p-2 rounded hover:bg-primary50 hover:border-b-2 hover:shadow-md hover:scale-[.95] transform transition-all">
                <i class="fas fa-check-to-slot">
                </i>
                <span>
                    Delivered
                </span>
            </button>
            <button name="ordercancel_orders" onclick="btnActionsClicked(this)" class="flex items-center justify-center space-x-2 border border-accent p-2 rounded hover:bg-red-400 hover:border-b-2 hover:shadow-md hover:scale-[.95] transform transition-all">
                <i class="fas fa-ban">
                </i>
                <span>
                    Cancel
                </span>
            </button>
        </div>
    </div>

    <div class="h-[90%] relative overflow-y-auto  container border-t-2 border-accent ">
        <div class="w-full flex flex-col">

            <!-- Header  -->
            <div class="flex items-center justify-around space-x-2 border-b px-2 py-2 bg-gray-100">
                <h3 class="w-[10%] px-4 text-left text-ellipsis font-semibold text-sm">
                    #
                </h3>
                <h3 class="w-1/6 text-center text-ellipsis font-semibold text-sm">
                    Order Date
                </h3>
                <h3 class="w-1/6 text-left text-ellipsis font-semibold text-sm">
                    Customer
                </h3>
                <h3 class="w-1/6 text-left text-ellipsis font-semibold text-sm">
                    Product
                </h3>
                <h3 class="w-1/6 text-center text-ellipsis font-semibold text-sm">
                    Qty
                </h3>
                <h3 class="w-1/6 text-center text-ellipsis font-semibold text-sm">
                    Item Cost
                </h3>
                <h3 class="w-1/6 text-center text-ellipsis font-semibold text-sm">
                    Status
                </h3>
                <h3 class="w-1/6 text-center text-ellipsis font-semibold text-sm">
                    &nbsp;
                </h3>
            </div>
            <?php
            $prevId = null;
            $accSubtotal = 0;
            ?>
            <?php foreach ($orders as $order) : ?>

                <?php

                // Result Info unpack
                $id = $order['id'];
                $itemId = $order['product_id'];
                $itemName = $order['item_name'];
                $itemPrice = $order['price'];
                $itemQuantity = $order['quantity'];
                $itemImage = $order['image_dir'];
                $priceCost = $itemPrice * $itemQuantity;
                $total = $order['cost'];
                $tax = 0.12;
                $subtotal = $priceCost + ($priceCost * $tax);
                $shippingType = $order['shipping_type'];
                $shippingDate = $order['ship_date'];
                $shipAmount = $order['shipping_fee'];
                $orderStatus = $order['status'];
                $customerName = $order['customer_name'];
                $customerAddress = $order['address'];
                // Groups the items based on order id
                if ($prevId != $id) {
                    $info = [
                        'id' => $id,
                        'ship_type' => $shippingType,
                        'ship_date' => $shippingDate,
                        'status' =>   $orderStatus,
                        'shipping_fee' => $shipAmount,
                        'customer_name' => $customerName,
                        'address' => $customerAddress,
                        'ship_date' => $order['ship_date'],
                        'items' => [
                            "item_$itemId" => [
                                'product_id' => $itemId,
                                'item_name' => $itemName,
                                'price' => $itemPrice,
                                'quantity' => $itemQuantity,
                                'image_dir' => $itemImage,
                                'cost' => $total
                            ]
                        ]
                    ];
                    $groupedResult["order_$id"] = $info;
                    $accSubtotal = 0;
                } else {
                    $item = [
                        'product_id' => $itemId,
                        'item_name' => $itemName,
                        'price' => $itemPrice,
                        'quantity' => $itemQuantity,
                        'image_dir' => $itemImage,
                        'cost' => $total
                    ];
                    $groupedResult["order_$id"]['items']["item_$itemId"] = $item;
                }

                $accSubtotal += $subtotal;


                ?>

                <div onclick="rowClicked(this)" name="orders_<?= $order['id'] ?>" id="orders_<?= $order['id'] ?>" class="flex items-center justify-around space-x-2 border-b p-1 py-2 hover:bg-primary30 hover:border-y-2 hover:border-accent hover:scale-x-105 hover:font-bold transform transition-all">

                    <!-- ID -->
                    <p class="w-[10%] px-4 text-left text-ellipsis font-light text-sm">
                        <?= $order['id'] ?>
                    </p>

                    <!-- Order date -->
                    <p class="w-1/6 text-center text-ellipsis font-light text-sm">
                        <?= $order['create_date'] ?>
                    </p>

                    <!-- Customer  -->
                    <p class="w-1/6 text-left text-ellipsis font-light text-sm">
                        <?= $order['customer_name'] ?>
                    </p>

                    <!-- Product -->
                    <p class="w-1/6 text-left text-ellipsis font-light text-sm">
                        <?= $order['item_name'] ?>

                    </p>

                    <!-- Quantity -->
                    <p class="w-1/6 text-center text-ellipsis font-light text-sm">
                        <?= $order['quantity'] ?>
                    </p>
                    <!-- Item Cost -->
                    <p class="w-1/6 text-center text-ellipsis font-light text-sm">
                        <?= $order['cost'] ?>
                    </p>
                    <!-- Status -->
                    <p class="w-1/6 text-center text-ellipsis font-light text-sm" id="orders_status_<?= $order['id'] ?>">
                        <?= $order['status'] ?>
                    </p>

                    <!-- View More -->
                    <a name="viewItem" href="./?page=orders&id=<?= $order['id'] ?>" class="w-1/6 z-10 text-center p-2 px-4 font-light text-sm relative">
                        <i class="fas fa-caret-right hover:text-3xl hover:text-secondary transform transition-all"></i>
                    </a>
                </div>
                <?php $prevId = $id ?>
            <?php endforeach; ?>

        </div>
    </div>
</div>



<!-- Modal -->
<?php
$isValid = !empty($_GET['id']) && is_numeric($_GET['id']);
?>
<?php if ($isValid) : ?>

    <?php
    $id = $_GET['id'];
    $order = $groupedResult["order_$id"];
    $tax = 0.12;
    $customerName = $order['customer_name'];
    $customerAddress = $order['address'];
    $shippingType = $order['ship_type'];
    $shippingDate = $order['ship_date'];
    $shipAmount = $order['shipping_fee'];
    $orderStatus = $order['status'];
    $items = $order['items'];

    $accSubtotal = 0;
    $total = 0;

    // echo '<pre>';
    // print_r($order);
    // echo '</pre>';
    // exit;
    ?>
    <!-- Manage an Order -->
    <div class="<? $id ? '' : 'hidden' ?>  fixed z-10 top-0 w-full left-0  overflow-y-auto" id="modal">
        <div class="flex items-center justify-center h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

            <div class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-900 opacity-20" />
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">
                &#8203;
            </span>

            <div class="h-full inline-block align-center py-4 transform transition-all align-middle w-full max-w-2xl">

                <div class="animate-fall relative container flex flex-col justify-between rounded-lg h-full shadow-xl border border-accent30 bg-white pt-4">

                    <div class="flex px-4 pb-4 items-center justify-between border-b-2">
                        <h1 class="text-xl font-bold text-accent md:text-3xl">
                            Order #<?= $id ?>
                        </h1>
                        <a class="px-2 rounded border-red-600 border hover:bg-red-300 mr-2" href="./?page=orders" name="closeModal" id="closeModal_<?= $itemId ?>"><i class=" fas fa-times"></i></a>
                    </div>

                    <div class="h-full overflow-y-auto py-3 px-6 text-left flex flex-col space-y-4">
                        <!-- Order Details -->
                        <!-- Customer Info -->
                        <div class="flex justify-between items-center">
                            <p class="text-sm font-light">
                                Name: <?= $customerName ?>
                            </p>

                            <!-- Order Date -->
                            <p class="text-sm font-light">
                                Ship Date: <strong><?= $shippingDate ?></strong>
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

                        <div class="container  flex flex-col space-y-2">

                            <div class="hidden sm:grid grid-cols-1 gap-5 text-left  md:grid-cols-4 md:grid border-b-2 border-accent">
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
                            <?php foreach ($items as $item) : ?>
                                <?php
                                $itemId = $item['product_id'];
                                $itemName = $item['item_name'];
                                $itemPrice = $item['price'];
                                $itemQuantity = $item['quantity'];
                                $itemImage = $item['image_dir'];
                                $priceCost = $itemPrice * $itemQuantity;
                                $subtotal = $priceCost + ($priceCost * $tax);
                                $accSubtotal += $subtotal;

                                ?>

                                <div class="grid grid-cols-1 gap-5 text-left  md:grid-cols-4">
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
                                        P<?= $itemPrice ?>
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

                                <div id="std" onclick="" class="flex  space-x-4 items-center cursor-pointer">
                                    <div name="chkstd" id="chkStd" class="<?= strtolower($shippingType) == 'standard' ? 'chkChecked bg-primary' : '' ?> border-b-2 flex items-center justify-center w-6 h-6 aspect-square border border-accent rounded hover:transform hover:transition-all hover:bg-secondary ">
                                        <i class="<?= strtolower($shippingType) == 'standard' ? '' : 'hidden' ?> fas fa-check"></i>
                                    </div>

                                    <span class="text-sm font-md border-accent hover:transform hover:transition-all hover:border-b-2 cursor-pointer">Standard</span>
                                </div>
                                <div id="exp" onclick="" class="flex space-x-4 items-center cursor-pointer">
                                    <div name="chkexp" id="chkExp" class="<?= strtolower($shippingType) == 'express' ? 'chkChecked bg-primary' : '' ?> w-6 h-6 flex items-center justify-center aspect-square border border-accent rounded hover:transform hover:transition-all hover:bg-secondary "><i class="<?= strtolower($shippingType) == 'express' ? 'bg-primary' : 'hidden' ?> fas fa-check"></i></div>

                                    <span class="text-sm font-md border-accent hover:transform hover:transition-all hover:border-b-2 cursor-pointer">Express</span>
                                </div>
                                <div id="prt" onclick="" class="flex space-x-4 items-center cursor-pointer">
                                    <div name="chkprt" id="chkPrt" class="<?= strtolower($shippingType) == 'priority' ? 'chkChecked bg-primary' : '' ?> w-6 h-6 aspect-square border border-accent flex items-center justify-center rounded hover:transform hover:transition-all hover:bg-secondary "><i class="<?= strtolower($shippingType) == 'priority' ? 'bg-primary' : 'hidden' ?> fas fa-check"></i></div>
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
                                    ₱ <span id="accsubtotal"><?= $accSubtotal ?></span>
                                </h1>
                            </div>
                            <!-- Shipping Fee -->
                            <div class="flex justify-between items-center">
                                <p class="text-sm font-light">
                                    Shipping Fee
                                </p>
                                <h1 class="text-md">
                                    ₱ <span id="shippingfee"><?= $shipAmount ?? 150 ?></span>
                                </h1>
                            </div>
                            <!-- Total -->
                            <div class="flex justify-between items-center">
                                <p class="text-lg font-bold">
                                    Total
                                </p>
                                <?php $total = $accSubtotal + $shipAmount ?>
                                <h1 class="text-lg font-bold">
                                    ₱ <span id="txtTotal"><?= $total ?></span>
                                </h1>
                            </div>
                        </div>


                        <h1 class="<?= strtolower($orderStatus) == 'pending' ? 'hidden' : '' ?> w-full text-center py-2 border-y-2 border-accent text-2xl">
                            <?= $orderStatus ?>
                        </h1>
                    </div>




                    <!-- BUTTONS -->

                    <div class="<?= strtolower($orderStatus) == 'pending' ? '' : 'flex justify-center' ?> bg-opacity-80 border-t border-accent rounded-b-md right-0 w-full bg-gray-200 md:px-4 py-3 text-right ">

                        <a href="./?page=orders&res=confirmorderdelete&order_id=<?= $id ?>" class="<?= strtolower($orderStatus) == 'pending' ? '' : 'hidden' ?> cursor-pointer py-2 px-4 border border-red-600 rounded hover:bg-red-300 mr-2" name="btnDeleteOrder_<?= $id ?>" id="btnDeleteOrder_<?= $id ?>">

                            <i class=" fas fa-times"></i>
                            Delete Order

                        </a>

                        <a href="./?page=orders&res=confirmordercancel&order_id=<?= $id ?>" class="<?= strtolower($orderStatus) == 'pending' ? '' : 'hidden' ?> cursor-pointer py-2 px-4 border border-red-600 rounded hover:bg-red-300 mr-2" name="btnCancelOrder_<?= $id ?>" id="btnCancelOrder_<?= $id ?>">

                            <i class=" fas fa-times"></i>
                            Cancel Order

                        </a>

                        <a href="./?page=orders&res=confirmordership&order_id=<?= $id ?>" name="btnUpdateOrder_<?= $id ?>" id="btnShipOrder_<?= $id ?>" type="submit" class="<?= strtolower($orderStatus) == 'pending' ? '' : 'hidden' ?> py-2 px-4 border border-primary rounded hover:bg-blue-400 hover:text-accent mr-2"><i class="fas fa-check"></i> Ship</a>

                        <a href="./?page=orders&res=confirmorderdeliver&order_id=<?= $id ?>" name="btnDeliverOrder_<?= $id ?>" id="btnDeliverOrder_<?= $id ?>" type="submit" class="<?= strtolower($orderStatus) == 'shipping' ? '' : 'hidden' ?> py-2 px-4 border border-primary rounded hover:bg-blue-400 hover:text-accent mr-2"><i class="fas fa-check"></i> Delivered</a>


                    </div>

                </div>


            </div>
        </div>
    </div>


<?php endif; ?>


<?php

$res = isset($_GET['res']) ? $_GET['res'] : null;
$orderId = isset($_GET['order_id']) ?  $_GET['order_id'] : null;
switch ($res) {
    case 'orderupdatesuccess':
        echo createModal(
            visible: true,
            title: "Order Updated Successfully",
            message: "The information has been updated for ORDER: $orderId STATUS: " . $_GET['type'],
        );
        break;
    case 'orderdeletesuccess':
        echo createModal(
            visible: true,
            title: "Order Deleted Successfully",
            message: "Order Info has successfully deleted",
        );
        break;
    case 'confirmorderdelete':
        echo createModal(
            visible: true,
            title: "Confirm Order Delete",
            message: "Are you sure you want to delete this item?",
            btnConfirm: "Confirm",
            btnFunc: "updateOrderStatus('delete', $orderId)",

        );
        break;
    case 'confirmordercancel':
        echo createModal(
            visible: true,
            title: "Confirm Order Cancel",
            message: "Are you sure you want to cancel this item?",
            btnConfirm: "Confirm",
            btnFunc: "updateOrderStatus('cancelled', $orderId)",

        );
        break;
    case 'confirmordership':
        echo createModal(
            visible: true,
            title: "Confirm Order Ship",
            message: "Are you sure you want to ship this item?",
            btnConfirm: "Confirm",
            btnFunc: "updateOrderStatus('shipping', $orderId)",

        );
        break;
    case 'confirmorderdeliver':
        echo createModal(
            visible: true,
            title: "Confirm Order Deliver",
            message: "Are you sure you want to deliver this item?",
            btnConfirm: "Confirm",
            btnFunc: "updateOrderStatus('delivered', $orderId)",

        );
        break;
    default:
        break;
}
error_reporting(E_ALL);

?>