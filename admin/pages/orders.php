<?php

session_start();

$status = $_GET['status'];
$query = <<<SQL

SELECT 
o.id,
o.create_date,
CONCAT(c.first_name, ' ', c.last_name) as customer_name,
CONCAT(p.id, ': ' ,p.item_name) as product,
ohp.quantity as quantity,
ohp.cost as item_cost,
o.status as 'status',
o.shipping_type,
o.ship_date

FROM `order` as o
INNER JOIN `order_has_product` as ohp
ON o.id = ohp.order_id
INNER JOIN `product` as p
ON ohp.product_id = p.id
INNER JOIN `customer` as c
ON o.customer_id = c.id

WHERE o.status LIKE '%${$status}%'

SQL;
try {

    $dbc = new DatabaseConfig();

    $orders = $dbc->executeQuery(
        $query
    );
} catch (Exception $ex) {
    echo $ex->getMessage();
}


?>


<!-- BUTTONS -->
<div class="container flex items-center justify-between">
    <h3>Selected Item: <span id="selectedItemId">_</span> </h3>
    <div class="flex justify-end space-x-4 px-4 text-sm">
        <button id="create_orders" name="create_orders" onclick="btnActionsClicked(this)" class="flex items-center justify-center space-x-2 border border-accent p-2 rounded hover:bg-primary50 hover:border-b-2 hover:shadow-md hover:scale-[.95] transform transition-all">
            <i class="fas fa-plus">
            </i>
            <span>
                Add New
            </span>
        </button>
        <button id="edit_orders" name="edit_orders" onclick="btnActionsClicked(this)" class="flex items-center justify-center space-x-2 border border-accent p-2 rounded hover:bg-primary50 hover:border-b-2 hover:shadow-md hover:scale-[.95] transform transition-all">
            <i class="fas fa-pen">
            </i>
            <span>
                Edit
            </span>
        </button>
        <button id="delete_orders" name="delete_orders" onclick="btnActionsClicked(this)" class="text-red-400 flex items-center justify-center space-x-2 border border-accent p-2 rounded hover:bg-primary50 hover:border-b-2 hover:shadow-md hover:scale-[.95] transform transition-all">
            <i class="fas fa-trash">
            </i>
            <span>
                Delete
            </span>
        </button>
    </div>
</div>



<div class="container border-t-2 border-accent ">
    <div class="w-full flex flex-col">

        <!-- Header  -->
        <div class="flex items-center justify-around space-x-2 border-b p-1 py-2 bg-gray-100">
            <h3 class="w-1/6 text-center text-ellipsis font-semibold text-sm">
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
                &nbsp;
            </h3>
        </div>

        <?php foreach ($orders as $order) : ?>


            <div onclick="rowClicked(this)" name="orders_<?= $order['id'] ?>" id="orders_<?= $order['id'] ?>" class="flex items-center justify-around space-x-2 border-b  p-1 py-2 hover:bg-primary30 hover:border-y-2 hover:border-accent hover:scale-x-105 hover:font-bold transform transition-all">

                <!-- ID -->
                <p class="w-1/6 text-center text-ellipsis font-light text-sm">
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
                    <?= $order['product'] ?>

                </p>

                <!-- Quantity -->
                <p class="w-1/6 text-center text-ellipsis font-light text-sm">
                    <?= $order['quantity'] ?>
                </p>
                <!-- Item Cost -->
                <p class="w-1/6 text-center text-ellipsis font-light text-sm">
                    <?= $order['item_cost'] ?>
                </p>

                <!-- View More -->
                <a name="viewItem" href="./?page=inventory&id=<?= $product['id'] ?>" class="w-1/6 z-10 text-center p-2 px-4 font-light text-sm relative">
                    <i class="fas fa-caret-right hover:text-3xl hover:text-secondary transform transition-all"></i>
                </a>
            </div>
        <?php endforeach; ?>

    </div>
</div>