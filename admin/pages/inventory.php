<?php

session_start();

$query = <<<SQL

SELECT 
p.id,
p.item_name,
p.price,
p.stock_quantity,
p.brand,
s.name as supplier
FROM
product as p

INNER JOIN supplier as s ON s.id = p.supplier_id

SQL;
try {

    $dbc = new DatabaseConfig();

    $products = $dbc->executeQuery($query);
} catch (Exception $ex) {
}


?>
<!-- BUTTONS -->
<div class="container flex justify-end space-x-4 px-4 text-sm">
    <div class="flex items-center justify-center space-x-2 border border-accent p-2 rounded hover:bg-primary50 hover:border-b-2 hover:shadow-md hover:scale-[.95] transform transition-all">
        <i class="fas fa-plus">
        </i>
        <button class="">
            Create New
        </button>
    </div>
    <div class="flex items-center justify-center space-x-2 border border-accent p-2 rounded hover:bg-primary50 hover:border-b-2 hover:shadow-md hover:scale-[.95] transform transition-all">
        <i class="fas fa-pen">
        </i>
        <button class="">
            Edit
        </button>
    </div>
    <div class="text-red-400 flex items-center justify-center space-x-2 border border-accent p-2 rounded hover:bg-primary50 hover:border-b-2 hover:shadow-md hover:scale-[.95] transform transition-all">
        <i class="fas fa-trash">
        </i>
        <button class="">
            Delete
        </button>
    </div>
</div>

<div class="relative container border-t-2 border-accent ">
    <div class="w-full flex flex-col">

        <!-- Header  -->
        <div class="flex items-center justify-around space-x-2 border-b p-1 py-2 bg-gray-100">
            <h3 class="w-1/6 text-center text-ellipsis font-semibold text-sm">
                #
            </h3>
            <h3 class="w-1/6 text-center text-ellipsis font-semibold text-sm">
                Name
            </h3>
            <h3 class="w-1/6 text-center text-ellipsis font-semibold text-sm">
                Stock
            </h3>
            <h3 class="w-1/6 text-center text-ellipsis font-semibold text-sm">
                Price
            </h3>
            <h3 class="w-1/6 text-center text-ellipsis font-semibold text-sm">
                Brand
            </h3>
            <h3 class="w-1/6 text-center text-ellipsis font-semibold text-sm">
                Supplier
            </h3>
            <h3 class="w-1/6 text-center text-ellipsis font-semibold text-sm">
                &nbsp;
            </h3>
        </div>

        <?php foreach ($products as $product) : ?>


            <div name="product_<?= $product['id'] ?>" id="product_<?= $product['id'] ?>" class="flex items-center justify-around space-x-2 border-b p-1 py-2 hover:bg-primary30 hover:border-b-2 hover:border-accent hover:scale-x-105 hover:font-bold transform transition-all">

                <!-- ID -->
                <p class="w-1/6 text-center text-ellipsis font-light text-sm">
                    <?= $product['id'] ?>
                </p>

                <!-- Name -->
                <p class="w-1/6 text-left text-ellipsis font-light text-sm">
                    <?= $product['item_name'] ?>
                </p>

                <!-- Stock  -->
                <p class="w-1/6 text-center text-ellipsis font-light text-sm">
                    <?= $product['stock_quantity'] ?>
                </p>

                <!-- Price -->
                <p class="w-1/6 text-center text-ellipsis font-light text-sm">
                    <?= $product['price'] ?>
                </p>

                <!-- Brand -->
                <p class="w-1/6 text-center text-ellipsis font-light text-sm">
                    <?= $product['brand'] ?>
                </p>
                <!-- Supplier -->
                <p class="w-1/6 text-center text-ellipsis font-light text-sm">
                    <?= wordwrap($product['supplier'], 10, '<br>', true) ?>
                </p>

                <!-- View More -->
                <p class="w-1/6 text-center font-light text-sm relative">
                    <i class="fas fa-caret-right"></i>
                </p>
            </div>
        <?php endforeach; ?>

    </div>
</div>