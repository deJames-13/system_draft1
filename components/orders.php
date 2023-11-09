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

?>

<div class="shop-panel-wrapper container p-6 mb-8 mx-4 border border-t-2 border-accent overflow-scroll rounded-t-xl flex flex-col items-start">
  <div class="container border-0 border-b-2 pb-2 text-3xl text-accent flex justify-between items-center ">
    <div class="flex space-x-3 items-center">
      <i class="fas fa-cart-shopping"></i>
      <h1 class="font-bold">Your Orders</h1>
    </div>

    <div id="ordertype" class="flex space-x-4 items-center ">
      <a href="?page=orders&type=pending" class="p-2 rounded border-accent text-sm font-semibold <?= $type == 'pending' ? 'bg-primary30 border' : 'bg-none' ?>  hover:bg-secondary50">Pending</a>
      <a href="?page=orders&type=shipped" class="p-2 rounded border-accent text-sm font-semibold <?= $type == 'shipped' ? 'bg-primary30 border' : 'bg-none' ?>  hover:bg-secondary50">Shipped</a>
      <a href="?page=orders&type=delivered" class="p-2 rounded border-accent text-sm font-semibold <?= $type == 'delivered' ? 'bg-primary30 border' : 'bg-none' ?>  hover:bg-secondary50">Delivered</a>
      <a href="?page=orders&type=cancelled" class="p-2 rounded border-accent text-sm font-semibold <?= $type == 'cancelled' ? 'bg-primary30 border' : 'bg-none' ?>  hover:bg-secondary50">Cancelled</a>
    </div>

  </div>

  <!-- Order List -->
  <div class="w-full flex flex-col mt-2 space-y-4">
    <?php foreach ($result as $i => $row) : ?>

      <?php
      $index = $i + 1;
      $id = $row['id'];
      $itemId = $row['product_id'];
      $itemName = $row['item_name'];
      $itemPrice = $row['price'];
      $itemQuantity = $row['quantity'];
      $itemImage = $row['image_dir'];
      $total = $row['cost'];
      $shippingType = $row['ship_type'];
      $shippingDate = $row['ship_date'];
      $shipAmount = $row['shipping_fee'];
      $orderStatus = $row['status'];



      ?>

      <!-- Order -->
      <div class="container flex flex-col-reverse my-4">

        <!-- Order Card -->
        <div class="border border-accent rounded-md bg-primary10 hover:border-2 hover:bg-primary30 lg:flex lg:space-x-4">

          <!-- Item Image -->
          <div class="container h-32 p-8 flex justify-center items-center bg-white rounded-t-md lg:rounded-l-md  lg:h-48 lg:max-w-xs ">
            <img src="<?= $itemImage ?>" alt="" class=" object-contain h-full w-full" />
          </div>

          <div class="container px-4 py-4 lg:flex  lg:justify-between lg:space-x-4">

            <!-- Cart Info -->
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
                <p> ₱ <?= $itemPrice ?> x<?= $itemQuantity ?></p>

                <p class="text-ellipsis whitespace-nowrap hidden md:block">Shipping</p>
                <p> ₱ <?= $shipAmount ?></p>

                <p class="text-ellipsis whitespace-nowrap hidden md:block">VAT</p>
                <p> 12% </p>
              </div>

              <!-- Total -->
              <div class="py-4 md:px-8 lg:px-0">
                <p class="text-md font-semibold">Total: <strong> ₱<?= $total ?></strong></p>
              </div>
            </div>


            <!-- Quantity Buttons -->
            <div id="qtyBtns_<?= $index ?>" class="menu-hidden h-full flex flex-row-reverse justify-around lg:flex-col  items-center">


              <!-- Plus Qty -->
              <button onclick="setQty(this)" name="addBtn_<?= $index ?>" id="addBtn_<?= $index ?>" class="border p-2 aspect-square flex items-center justify-center border-accent hover:bg-primary50">
                <i class="fas fa-plus"></i>
              </button>


              <div id="setQty_<?= $index ?>" class="p-2 aspect-square flex items-center justify-center">
                <p class="text-semibold text-lg">
                  <?= $itemQuantity ?>
                </p>
              </div>


              <!-- Sub Qty -->
              <button onclick="setQty(this)" name="subBtn_<?= $index ?>" id="subBtn_<?= $index ?>" class="border p-2 aspect-square flex items-center justify-center border-accent hover:bg-primary50">
                <i class="fas fa-minus"></i>
              </button>

            </div>
          </div>



          <!-- Actions -->
          <div class="">
            <div id="btnShow_<?= $index ?>" onclick="swapCardAction(this)" class="h-full p-4 flex justify-center items-center rounded-b-md border-t lg:border-l lg:rounded-b-none lg:rounded-br-md lg:rounded-tr-md hover:bg-secondary30">
              <i class="fas fa-bars"></i>
            </div>
          </div>
          <div class="menu-hidden flex items-center justify-around lg:flex-col">
            <a href="./?page=orders&idx=<?= $index ?>" class="flex items-center justify-center w-full h-full p-4 border-t border-accent rounded-bl-md lg:rounded-b-none lg:rounded-tr-md lg:border-t-0 lg:border-l hover:bg-primary">
              <i class="fas fa-pen hover:text-secondary"></i>
            </a>
            <div id="btnHide_<?= $index ?>" onclick="swapCardAction(this)" class="flex items-center justify-center w-full h-full border-t border-accent p-4 rounded-br-md lg:rounded-b-none lg:rounded-br-md lg:border-l hover:bg-red-300">
              <i class="fas fa-xmark hover:text-red-600"></i>
            </div>
          </div>

        </div>


        <!-- Order ID -->

        <?php if (!isset($prevID) || $prevID != $id) : ?>
          <p class=" text-ellipsis whitespace-nowrap pt-2 md:block">
            Order ID:
            <span class="text-lg font-bold"><?= $id ?></span>
          </p>
          <div class="h-[2px] w-full bg-accent"></div>
        <?php endif; ?>

        <?php $prevID = $id; ?>

      </div>


    <?php endforeach; ?>

  </div>


  <br /><br />
</div>

<?php if (!empty($_GET['idx']) && is_numeric($_GET['idx'])) : ?>

  <?php

  $index = $_GET['idx'] - 1;
  $row = $result[$index];
  $customerName = $row['customer_name'];
  $customerAddress = $row['address'];
  $id = $row['id'];
  $itemId = $row['product_id'];
  $itemName = $row['item_name'];
  $itemPrice = $row['price'];
  $itemQuantity = $row['quantity'];
  $itemImage = $row['image_dir'];
  $subtotal = $itemPrice * $itemQuantity;
  $tax = 0.12;
  $subtotal = $subtotal + ($subtotal * $tax);
  $total = $row['cost'];
  $shippingType = $row['ship_type'];
  $shippingDate = $row['ship_date'];
  $shipAmount = $row['shipping_fee'];
  $orderStatus = $row['status'];

  ?>

  <!-- Manage an Order -->
  <div class="fixed z-10 top-0 w-full left-0  overflow-y-auto" id="modal">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

      <div class="fixed inset-0 transition-opacity">
        <div class="absolute inset-0 bg-gray-900 opacity-20" />
      </div>
      <span class="hidden sm:inline-block sm:align-middle sm:h-screen">
        &#8203;
      </span>

      <div class="h-[95%] inline-block align-center overflow-y-auto py-8 transform transition-all align-middle w-full max-w-xl" role="dialog" aria-modal="true" aria-labelledby="modal-headline">

        <form method="post" action="./order_add.php" class="container flex flex-col justify-between rounded-lg overflow-y-auto shadow-xl h-full border border-accent30 bg-white pt-4">

          <div class="flex px-4 pb-4 items-center justify-between border-b-2">
            <h1 class="text-xl font-bold text-accent md:text-3xl">
              Order #<?= $id ?>
            </h1>
            <a class="py-2 px-4 border border-red-600 rounded hover:bg-red-300 mr-2" href="./?page=orders" name="closeModal" id="closeModal_<?= $itemId ?>"><i class=" fas fa-times"></i></a>
          </div>

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
                  P<?= $itemPrice ?>
                </h1>
              </div>

              <!-- Quantity -->
              <div class="flex justify-between items-center">
                <p class="text-sm font-light">
                  Qty
                </p>
                <h1 class="text-md">
                  <?= $itemQuantity ?>
                </h1>
              </div>
              <div class="my-2 text-left">
                <p class="self-start text-sm font-light"> Choose shipping mode: </p>

                <div class="flex items-center space-x-8 px-4 p-2">

                  <div id="std" onclick="setShipMode(this)" class="flex  space-x-4 items-center cursor-pointer">
                    <div name="chkstd" id="chkStd" class=" bg-primary border-b-2 flex items-center justify-center w-6 h-6 aspect-square border border-accent rounded hover:transform hover:transition-all hover:bg-secondary "><i class="fas fa-check"></i></div>
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
            </div>

            <!-- Cost Summary -->
            <div class="flex flex-col space-y-2">

              <div class="h-[0.1rem] bg-accent"></div>
              <!-- Sub Total -->
              <div class="flex justify-between items-center">
                <p class="text-sm font-light">
                  Sub Total
                </p>
                <h1 class="text-md">
                  P<?= $subtotal ?>
                </h1>
              </div>
              <!-- Shipping Fee -->
              <div class="flex justify-between items-center">
                <p class="text-sm font-light">
                  Shipping Fee
                </p>
                <h1 id="shippingfee" class="text-md">
                  P<?= $shippingfee ?? 150 ?>
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
              <!-- Total -->
              <div class="flex justify-between items-center">
                <p class="text-lg font-bold">
                  Total
                </p>
                <h1 id="txtTotal" class="text-lg font-bold">
                  P<?= $total ?>
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

            <button class="py-2 px-4 border border-red-600 rounded hover:bg-red-300 mr-2" href="./?page=orders" name="closeModal" id="closeModal_<?= $itemId ?>"><i class=" fas fa-times"></i> Cancel Order</button>
            <button type="submit" class="py-2 px-4 bg-primary rounded hover:bg-blue-400 hover:text-accent mr-2"><i class="fas fa-check"></i> Update Order</button>

          </div>

        </form>


      </div>
    </div>
  </div>


<?php endif; ?>