<?php
$userName = $_SESSION['userName'];
$customerId = $_SESSION['userId'];
$type = $_GET['type'] ?? 'pending';

$query = <<<SQL
  SELECT
    ohp.order_id as id,
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
  
  WHERE o.customer_id = ? AND o.status = ?
  ORDER BY o.id DESC
SQL;

try {
  $dbc = new DatabaseConfig();
  $result = $dbc->executeQuery(
    query: $query,
    params: [
      "o.customer_id" => $customerId,
      "o.status" => $type
    ]
  );
} catch (Exception $e) {
  echo $e->getMessage();
}
// Group Result arry
$groupedResult = [];
?>

<!-- -------------------------------------------------------------- -->
<!-- ORDER LISTS -->
<!-- -------------------------------------------------------------- -->


<div class="relative shop-panel-wrapper container p-6 mb-8 mx-4 border border-t-2 border-accent overflow-scroll rounded-t-xl flex flex-col items-start">
  <div class="container border-0 border-b-2 pb-2  text-accent flex justify-between items-center ">

    <!-- TITLE -->
    <div class="flex space-x-3 items-center">
      <i class="fas fa-cart-shopping"></i>
      <h1 class="font-bold text-xl md:text-3xl">Your Orders</h1>
    </div>

    <!-- Menu Category -->
    <div id="ordertype" class=" space-x-2 items-center hidden md:flex">
      <a href="?page=orders&type=pending" class="p-2 rounded border-accent text-sm font-semibold <?= $type == 'pending' ? 'bg-primary30 border border-b-2' : 'bg-none' ?>  hover:bg-secondary50">Pending</a>
      <a href="?page=orders&type=shipped" class="p-2 rounded border-accent text-sm font-semibold <?= $type == 'shipped' ? 'bg-primary30 border border-b-2' : 'bg-none' ?>  hover:bg-secondary50">Shipped</a>
      <a href="?page=orders&type=delivered" class="p-2 rounded border-accent text-sm font-semibold <?= $type == 'delivered' ? 'bg-primary30 border border-b-2' : 'bg-none' ?>  hover:bg-secondary50">Delivered</a>
      <a href="?page=orders&type=cancelled" class="p-2 rounded border-accent text-sm font-semibold <?= $type == 'cancelled' ? 'bg-primary30 border border-b-2' : 'bg-none' ?>  hover:bg-secondary50">Cancelled</a>
    </div>

    <!-- Menu Mobile -->
    <div class="p-1 px-2 rounded-full border border-accent hover:bg-primary50 md:hidden">
      <a class="inline-block"><i class="fas fa-caret-down"></i></a>
    </div>


  </div>

  <!-- Order List -->
  <?php
  $prevId = null;
  $accSubtotal = 0;
  ?>
  <div class="w-full flex flex-col mt-2 space-y-4">
    <?php foreach ($result as $i => $row) : ?>
      <?php
      $orderStatus = $row['status'];
      if ($type != strtolower($orderStatus)) {
        continue;
      }


      // Result Info unpack
      $id = $row['id'];
      $itemId = $row['product_id'];
      $itemName = $row['item_name'];
      $itemPrice = $row['price'];
      $itemQuantity = $row['quantity'];
      $itemImage = $row['image_dir'];
      $priceCost = $itemPrice * $itemQuantity;
      $total = $row['cost'];
      $tax = 0.12;
      $subtotal = $priceCost + ($priceCost * $tax);
      $shippingType = $row['shipping_type'];
      $shippingDate = $row['ship_date'];
      $shipAmount = $row['shipping_fee'];

      // Groups the items based on order id

      if ($prevId != $id) {
        $info = [
          'id' => $id,
          'ship_type' => $shippingType,
          'ship_date' => $shippingDate,
          'status' =>   $orderStatus,
          'shipping_fee' => $shipAmount,
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

      $index = $i + 1;
      $accSubtotal += $subtotal;
      $script = <<<HTML
      <script>
        var el = document.getElementById("txtOrdertotal_" + $id) ?? null;
        if (el){
          el.innerText = $accSubtotal + $shipAmount;
          console.log(el.innerText);
        }
        </script>
      HTML;
      echo $script;

      ?>

      <!-- Order Card -->

      <!-- Order ID -->
      <?php if ($prevId != $id) : ?>
        <div class="container p-1 flex flex-col space-y-2 my-2 pb-4">
          <div class="container flex space-x-2 justify-between items-center border-b-2 border-accent ">
            <div class="container flex items-center justify-between">
              <h1 class=" text-ellipsis whitespace-nowrap pt-2 mb-2">
                Order ID:
                <span class="text-lg font-bold"><?= $id ?></span>
              </h1>
              <div class="h-full text-sm flex items-center space-x-4 justify-end">
                <!-- Shipping Fee -->
                <p class=" text-ellipsis whitespace-nowrap hidden md:block">Order Total:</p>
                <p> ₱ <span id="txtOrdertotal_<?= $id ?>"></span></p>
              </div>
            </div>


            <?php if ($type == 'pending') : ?>
              <div class="cursor-pointer bg-primary10 p-1 mx-2 flex items-center justify-center border border-accent rounded hover:border-2 hover:bg-primary">
                <a class="px-2" href="./?page=orders&id=<?= $id ?>">
                  <i class="fas fa-bars"></i>
                </a>
              </div>
            <?php endif; ?>
          </div>

        <?php endif; ?>

        <!-- Order Card -->
        <div class="h-full border border-accent rounded-md bg-primary10 hover:border-2 hover:bg-primary30 lg:flex lg:space-x-4">

          <!-- Item Image -->
          <div class="container h-52 flex justify-center items-center bg-white rounded-t-md p-8 lg:rounded-tr-none lg:rounded-l-md lg:max-w-xs ">
            <img src="<?= $itemImage ?>" alt="" class="object-contain h-full w-full" />
          </div>

          <div class="container px-4 py-4 lg:flex  lg:justify-between lg:space-x-4">

            <!-- Order Info -->
            <div class="flex flex-col h-full justify-between">
              <div class=" grid grid-cols-1 gap-x-4 text-sm font-light md:px-8 lg:px-0 md:grid-cols-2">

                <!-- Item ID -->
                <p class="text-ellipsis whitespace-nowrap  md:block">Item ID: <?= $itemId ?></p>
                <br>
                <!-- Item Name -->
                <p class="text-ellipsis whitespace-nowrap hidden md:block">Product Name</p>
                <p> <strong><?= $itemName ?></strong> </p>

                <!-- Price -->
                <p class="text-ellipsis whitespace-nowrap hidden md:block">Price</p>
                <p> ₱ <span id="txtPrc_<?= $id . '_' . $itemId ?>"><?= $itemPrice ?></span> x <span id="txtQuant<?= $id . '_' . $item_id ?>"><?= $itemQuantity ?></span></p>

                <!-- TAX -->
                <p class="text-ellipsis whitespace-nowrap hidden md:block">VAT</p>
                <p> <?= $tax * 100 ?>%</p>

                <!-- SUB TOTAL -->
                <p class="text-ellipsis whitespace-nowrap hidden md:block">Sub Total</p>
                <p>₱ <span id="txtSub_<?= $id . '_' . $itemId ?>"><?= $subtotal ?></span></p>

              </div>

              <!-- Total -->
              <div class="pt-4 md:px-8 lg:px-0">
                <p class="text-md">Item Total: <strong> ₱ <span><?= $total ?></span></strong></p>
              </div>
            </div>

            <!-- Quantity Buttons -->
            <div id="qtyBtns_<?= $index ?>" class="menu-hidden h-full flex flex-row-reverse justify-around lg:flex-col  items-center">

              <!-- Plus Qty -->
              <button onclick="setQty(this)" name="addBtn_<?= $id . '_' . $item_id ?>" id="addBtn_<?= $id . '_' . $itemId ?>" class="border p-2 aspect-square flex items-center justify-center border-accent hover:bg-primary50">
                <i class="fas fa-plus"></i>
              </button>

              <!-- Qty -->
              <div id="setQty_<?= $id . '_' . $itemId ?>" class="p-2 aspect-square flex items-center justify-center">
                <p class="text-semibold text-lg">
                  <?= $itemQuantity ?>
                </p>
              </div>

              <!-- Sub Qty -->
              <button onclick="setQty(this)" name="subBtn_<?= $id . '_' . $item_id ?>" id="subBtn_<?= $id . '_' . $itemId ?>" class="border p-2 aspect-square flex items-center justify-center border-accent hover:bg-primary50">
                <i class="fas fa-minus"></i>
              </button>

            </div>
          </div>

          <!-- Actions -->
          <div class="<?php echo $type != 'pending' ? 'hidden' : '' ?>">
            <div id="btnShow_<?= $index ?>" onclick="swapCardAction(this)" class="h-full p-4 flex justify-center items-center rounded-b-md border-t lg:border-l lg:rounded-b-none lg:rounded-br-md lg:rounded-tr-md hover:bg-secondary30">
              <i class="fas fa-pen"></i>
            </div>
          </div>
          <div class="menu-hidden flex flex-row-reverse items-center justify-around lg:flex-col">

            <a onclick="manageOrder(this)" name="btnUpdateOrderItem_<?= $id . '_' . $itemId ?>" id="btnUpdateOrderItem_<?= $id . '_' . $itemId ?>" class="flex items-center justify-center w-full h-full border-t border-accent p-4 rounded-br-md lg:rounded-b-none lg:rounded-tr-md border-l lg:border-t-0 hover:bg-primary">
              <i class=" fas fa-check hover:text-secondary"></i>
            </a>

            <button onclick="manageOrder(this)" name="btnDeleteOrderItem_<?= $id . '_' . $itemId ?>" id="btnDeleteOrderItem_<?= $id . '_' . $itemId ?>" class="flex items-center justify-center w-full h-full p-4 border-t border-accent rounded-bl-md lg:rounded-b-none lg:rounded-br-md lg:border-t lg:border-l hover:bg-red-300">
              <i class="fas fa-trash hover:text-red-600"></i>
            </button>
          </div>

        </div>

        <?php if ($index == count($result) || $result[$index]['id'] != $id) : ?>
          <?php $accSubtotal = 0; ?>
        </div>
      <?php endif; ?>
      <?php $prevId = $id; ?>
    <?php endforeach; ?>
  </div>
  <br /><br />
</div>


<!-- -------------------------------------------------------------- -->
<!-- Manage an Order -->
<!-- -------------------------------------------------------------- -->
<?php
$isValid = !empty($_GET['id']) && is_numeric($_GET['id']);
?>
<?php if ($isValid) : ?>

  <?php

  $id = $_GET['id'];
  $customerName = $row['customer_name'];
  $customerAddress = $row['address'];
  $order = $groupedResult["order_$id"];
  $tax = 0.12;
  $shippingType = $order['ship_type'];
  $shippingDate = $order['ship_date'];
  $shipAmount = $order['shipping_fee'];
  $orderStatus = $order['status'];
  $items = $order['items'];

  $accSubtotal = 0;
  $total = 0;

  ?>


  <!-- Manage an Order -->
  <div class="<? $isItem ? '' : 'hidden' ?> fixed z-10 top-0 w-full left-0  overflow-y-auto" id="modal">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

      <div class="fixed inset-0 transition-opacity">
        <div class="absolute inset-0 bg-gray-900 opacity-20" />
      </div>
      <span class="hidden sm:inline-block sm:align-middle sm:h-screen">
        &#8203;
      </span>

      <div class="h-full inline-block align-center py-4 transform transition-all align-middle w-full max-w-2xl" role="dialog" aria-modal="true" aria-labelledby="modal-headline">

        <form method="post" action="./order_update.php?id=<?= $id ?>" class="pb-12 relative container flex flex-col justify-between rounded-lg overflow-y-auto h-full shadow-xl border border-accent30 bg-white pt-4">

          <div class="flex px-4 pb-4 items-center justify-between border-b-2">
            <h1 class="text-xl font-bold text-accent md:text-3xl">
              Order #<?= $id ?>
            </h1>
            <a class="px-2 rounded border-red-600 border hover:bg-red-300 mr-2" href="./?page=orders" name="closeModal" id="closeModal_<?= $itemId ?>"><i class=" fas fa-times"></i></a>
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
              <?php foreach ($items as $row) : ?>
                <?php
                $itemId = $row['product_id'];
                $itemName = $row['item_name'];
                $itemPrice = $row['price'];
                $itemQuantity = $row['quantity'];
                $itemImage = $row['image_dir'];
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
              <p class="self-start text-sm font-light"> Choose shipping mode: <?= empty($shippingType) ?></p>

              <div class="flex items-center space-x-8 px-4 p-2">

                <div id="std" onclick="setShipMode(this)" class="flex  space-x-4 items-center cursor-pointer">
                  <div name="chkstd" id="chkStd" class="<?= $shippingType == 'Standard' ? 'chkChecked bg-primary' : '' ?> border-b-2 flex items-center justify-center w-6 h-6 aspect-square border border-accent rounded hover:transform hover:transition-all hover:bg-secondary ">
                    <i class="<?= $shippingType == 'Standard' ? '' : 'hidden' ?> fas fa-check"></i>
                  </div>

                  <span class="text-sm font-md border-accent hover:transform hover:transition-all hover:border-b-2 cursor-pointer">Standard</span>
                </div>
                <div id="exp" onclick="setShipMode(this)" class="flex space-x-4 items-center cursor-pointer">
                  <div name="chkexp" id="chkExp" class="<?= $shippingType == 'Express' ? 'chkChecked bg-primary' : '' ?> w-6 h-6 flex items-center justify-center aspect-square border border-accent rounded hover:transform hover:transition-all hover:bg-secondary "><i class="<?= $shippingType == 'Express' ? 'bg-primary' : 'hidden' ?> fas fa-check"></i></div>

                  <span class="text-sm font-md border-accent hover:transform hover:transition-all hover:border-b-2 cursor-pointer">Express</span>
                </div>
                <div id="prt" onclick="setShipMode(this)" class="flex space-x-4 items-center cursor-pointer">
                  <div name="chkprt" id="chkPrt" class="<?= $shippingType == 'Priority' ? 'chkChecked bg-primary' : '' ?> w-6 h-6 aspect-square border border-accent flex items-center justify-center rounded hover:transform hover:transition-all hover:bg-secondary "><i class="<?= $shippingType == 'Priority' ? 'bg-primary' : 'hidden' ?> fas fa-check"></i></div>
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

          </div>

          <!-- Inputs for POST -->
          <div>
            <input type="hidden" name="productId" value="<?= $itemId ?>">
            <input type="hidden" name="quantity" value="<?= $itemQuantity ?>">
            <input type="hidden" name="subtotal" id="subtotal" value="<?= $accSubtotal ?>">
            <input type="hidden" name="shippingType" id="shippingType" value="<?= $shippingType ?? 'Standard' ?>">
            <input type="hidden" name="totalCost" id="totalCost" value="<?= $total ?>">
          </div>


          <!-- BUTTONS -->
          <div class="bottom-0 fixed md:bottom-3 bg-opacity-80 border-t border-accent rounded-b-md right-0 w-full bg-gray-200 md:px-4 py-3 text-right ">

            <a class="cursor-pointer py-2 px-4 border border-red-600 rounded hover:bg-red-300 mr-2" onclick="manageOrder(this)" name="btnDeleteOrder_<?= $id ?>" id="btnDeleteOrder_<?= $id ?>"><i class=" fas fa-times"></i> Cancel Order</a>

            <button onclick="manageOrder(this)" name="btnUpdateOrder_<?= $id ?>" id="btnUpdateOrder_<?= $id ?>" type="submit" class="py-2 px-4 bg-primary rounded hover:bg-blue-400 hover:text-accent mr-2"><i class="fas fa-check"></i> Update Order</button>
          </div>

        </form>


      </div>
    </div>
  </div>


<?php endif; ?>