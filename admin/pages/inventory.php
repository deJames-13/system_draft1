<?php

if ($_SESSION['userRoleId'] == 4) {
    header("Location: ./?page=employees&id=" . $_SESSION['adminId']);
}
$query = <<<SQL
SELECT 
p.*,
s.name as supplier
FROM
product as p
INNER JOIN supplier as s ON s.id = p.supplier_id

SQL;

$id = isset($_GET['id']) ? $_GET['id'] : null;
$mode = isset($_GET['mode']) ? $_GET['mode'] : null;
$searchVal = isset($_GET['search']) ? $_GET['search'] : null;

if ($searchVal) {
    $query .= " WHERE p.item_name LIKE '%$searchVal%' OR p.brand LIKE '%$searchVal%' OR s.name LIKE '%$searchVal%' OR p.description LIKE '%$searchVal%' or p.id LIKE '%$searchVal%'";
} elseif (!empty($_GET['id']) && $id > -1) {
    $query .= "WHERE p.id = '$id'";
} else {
    $query .= "ORDER BY p.id DESC";
}

try {

    $dbc = new DatabaseConfig();
    $products = $dbc->executeQuery($query);

    if ($mode == 'edit' || $mode == 'create') {
        $brands = $dbc->executeQuery("SELECT brand FROM product GROUP BY brand");
        $suppliers = $dbc->executeQuery("SELECT id, `name` FROM supplier");
    }
} catch (Exception $ex) {
}
include_once '../components/image-container.php';

?>

<?php if (isset($_GET['id']) && $id > -1 && $mode != 'edit') : ?>
    <?php
    $product = $products[0];
    $itemImage = $product['image_dir'];
    ?>

    <div class="container flex flex-col space-y-4 h-full">

        <!-- Title -->
        <div class="w-full flex items-center space-x-4 pb-4 border-b-2 border-accent">
            <i class="fas fa-box text-3xl text-accent"></i>
            <h1 class="text-xl md:text-3xl font-bold text-accent hover:text-secondary">
                Product View
            </h1>
        </div>

        <div class="flex-1 flex space-x-4 w-full h-full rounded">
            <div class="flex flex-col items-center space-y-4 max-w-sm w-full h-screen">

                <!-- Images -->
                <div class="p-4 flex flex-col items-center justify-center space-y-4 border border-accent rounded w-full">
                    <h3 class="w-full">Item Image</h3>
                    <div class="flex items-center justify-center aspect-square w-full border border-accent rounded p-4">


                        <?php showImageContainer($itemImage, "product"); ?>



                    </div>
                </div>


                <!-- Action buttons -->
                <div class="p-4 w-full h-1/4 flex flex-col space-y-4 ">
                    <a href="./?page=inventory&id=<?= $id ?>&mode=edit" class="w-full text-center rounded border border-accent p-2 bg-primary50 hover:scale-110 hover:border-b-2 transition-all transform">
                        Edit Information
                    </a>
                    <a href="./?page=inventory&id=<?= $id ?>&res=deleteconfirm" class="text-center w-full rounded border border-accent p-2 bg-red-300 hover:scale-110 hover:border-b-2 transition-all transform">
                        Delete
                    </a>
                </div>
            </div>

            <!-- Product Information -->
            <div class="flex flex-col space-y-4 w-full h-full">
                <div class="flex space-x-2 items-center border-b-2 py-4">
                    <i class="text-accent fas fa-info bg-primary30 aspect-square border border-accent p-1 rounded-full">
                    </i>
                    <h3 class="text-md font-medium">Product Information</h3>
                </div>

                <div class="w-full flex-col space-y-4 items-center">

                    <!-- Id -->
                    <div class="flex justify-between">
                        <p>Item Id:</p>
                        <h1 class="text-xl font-light">
                            000<?= $product['id'] ?>
                        </h1>
                    </div>


                    <!-- Name -->
                    <div class="flex justify-between">
                        <p>Item Name:</p>
                        <h1 class="text-3xl font-semibold">
                            <?= $product['item_name'] ?>
                        </h1>
                    </div>

                    <!-- Price -->
                    <div class="flex justify-between">
                        <p>Price:</p>
                        <h1 class="text-2xl font-semibold">
                            P <?= $product['price'] ?>
                        </h1>
                    </div>

                    <!-- Stock -->
                    <div class="flex justify-between">
                        <p>Stock Available:</p>
                        <h1 class="text-2xl font-semibold">
                            x<?= $product['stock_quantity'] ?>
                        </h1>
                    </div>

                    <!-- Brand -->
                    <div class="flex justify-between">
                        <p>Brand: </p>
                        <h1 class="text-xl f">
                            <?= $product['brand'] ?>
                        </h1>
                    </div>

                    <!-- Supplier -->
                    <div class="flex justify-between">
                        <p>Supplier: </p>
                        <h1 class="text-xl">
                            <?= $product['supplier'] ?>
                        </h1>
                    </div>

                    <!--Description -->
                    <div class="flex flex-col space-y-2">
                        <p>Description</p>
                        <textarea class="resize-none" name="description" id="productdesc_<?= $id ?>" cols="30" rows="5" disabled><?= $product['description'] ?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php elseif (isset($_GET['id'])  && $id > -1 && $mode == 'edit') : ?>

    <?php
    $product = $products[0];
    $itemImage = $product['image_dir'];
    ?>

    <div class="container flex flex-col space-y-4 h-full">

        <!-- Title -->
        <div class="w-full flex items-center space-x-4 pb-4 border-b-2 border-accent">
            <i class="fas fa-box text-3xl text-accent"></i>
            <h1 class="text-xl md:text-3xl font-bold text-accent hover:text-secondary">
                Product Edit
            </h1>
        </div>

        <form action="./inventory/update.php" method="post" enctype="multipart/form-data" class="flex-1 flex space-x-4 w-full h-full rounded">
            <div class="flex flex-col items-center space-y-4 max-w-sm w-full h-screen ">

                <!-- Images -->
                <div class="p-4 flex flex-col items-center justify-center space-y-4 border border-accent rounded w-full">
                    <h3 class="w-full">Item Image</h3>
                    <div class="flex items-center justify-center aspect-square w-full border border-accent rounded p-4">



                        <!-- IMAGE CONTAIN -->
                        <div class="w-full relative">
                            <div id="imageDisplay" class="max-w-full h-full  overflow-auto slider flex space-x-4 transition-all transform aspect-square">

                                <?php showImageContainer($itemImage, "product") ?>
                            </div>
                        </div>




                    </div>
                </div>

                <!-- Action buttons -->
                <div class="p-4 w-full flex-1 flex flex-col justify-between space-y-4 ">

                    <!-- IMAGE HANDLING -->
                    <div class="flex flex-col space-y-4">
                        <label for="images" class="w-full text-center rounded border border-accent p-2 bg-primary50 hover:scale-110 hover:border-b-2 transition-all transform">
                            Upload Image
                        </label>
                        <input type="file" name="images[]" id="images" class="hidden" multiple accept="image/*" onchange="handleFileSelect(event)" />
                    </div>



                    <!-- SUBIMIT BUTTONS -->
                    <button type="submit" name="action" value="update" id="update_<?= $id ?>" class="w-full rounded border border-accent p-2 bg-primary50 hover:scale-110 hover:border-b-2 transition-all transform">
                        Save Changes
                    </button>
                    <a href="./?page=inventory&id=<?= $id ?>" class="text-center w-full rounded border border-accent p-2 bg-red-300 hover:scale-110 hover:border-b-2 transition-all transform">
                        Cancel
                    </a>
                </div>
            </div>

            <!-- Product Information -->
            <div class="flex flex-col space-y-4 w-full h-full">
                <div class="flex space-x-2 items-center border-b-2 py-4">
                    <i class="text-accent fas fa-info bg-primary30 aspect-square border border-accent p-1 rounded-full">
                    </i>
                    <h3 class="text-md font-medium">Product Information</h3>
                </div>

                <div class="w-full flex-col space-y-4 items-center">

                    <!-- Id -->
                    <div class="flex justify-between">
                        <p>Item Id:</p>
                        <input type="number" class="text-right text-xl font-light" name="item_id" id="item_id_<?= $id ?>" value="<?= $product['id'] ?>" hidden />
                        <input type="number" class="text-right text-xl font-light" name="" value="<?= $product['id'] ?>" disabled />
                    </div>


                    <!-- Name -->
                    <div class="flex justify-between">
                        <p>Item Name:</p>
                        <input type="text" class="text-right text-3xl font-semibold" name="item_name" id="item_name_<?= $id ?>" value="<?= $product['item_name'] ?>" />

                    </div>

                    <!-- Price -->
                    <div class="flex justify-between">
                        <p>Price:</p>
                        <input type="number" class="text-right text-2xl font-semibold" name="price" id="price_<?= $id ?>" value="<?= $product['price'] ?>" />
                    </div>

                    <!-- Stock -->
                    <div class="flex justify-between">
                        <p>Stock Available:</p>
                        <input type="number" class="text-right text-2xl font-semibold" name="quantity" id="quantity_<?= $id ?>" value="<?= $product['stock_quantity'] ?>" />
                    </div>

                    <!-- Brand -->

                    <div class="flex justify-between">
                        <label for="dropdown_brand">Select Brand:</label>
                        <input class="text-right" list="opt_brands" id="dropdown_brand" name="brand" value="<?= $product['brand'] ?>">
                        <datalist id="opt_brands">
                            <?php foreach ($brands as $brand) : ?>
                                <option value="<?= $brand['brand'] ?>">
                                <?php endforeach; ?>
                        </datalist>
                    </div>

                    <!-- Supplier -->
                    <div class="flex justify-between">
                        <label for="dropdown">Select a supplier:</label>
                        <select id="dropdown_supplier" name="supplier">
                            <?php foreach ($suppliers as $s) : ?>
                                <option value="<?= $s['id'] ?>"><?= $s['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!--Description -->
                    <div class="flex flex-col space-y-2">
                        <p>Description</p>
                        <textarea class="resize-none" name="description" id="productdesc_<?= $id ?>" cols="30" rows="5"><?= $product['description'] ?></textarea>
                    </div>
                </div>
            </div>
        </form>
    </div>



<?php else : ?>


    <div class="container flex flex-col space-y-4 h-full overflow-y-hidden">

        <!-- BUTTONS -->
        <div class="flex items-center justify-between">
            <h3>Selected Item: <span id="selectedItemId">_</span> </h3>
            <div class="flex justify-end space-x-4 px-4 text-sm">
                <button id="create_inventory" name="create_inventory" onclick="btnActionsClicked(this)" class="flex items-center justify-center space-x-2 border border-accent p-2 rounded hover:bg-primary50 hover:border-b-2 hover:shadow-md hover:scale-[.95] transform transition-all">
                    <i class="fas fa-plus">
                    </i>
                    <span>
                        Add Item
                    </span>
                </button>
                <button id="edit_inventory" name="edit_inventory" onclick="btnActionsClicked(this)" class="flex items-center justify-center space-x-2 border border-accent p-2 rounded hover:bg-primary50 hover:border-b-2 hover:shadow-md hover:scale-[.95] transform transition-all">
                    <i class="fas fa-pen">
                    </i>
                    <span>
                        Edit
                    </span>
                </button>
                <button id="delete_inventory" name="delete_inventory" onclick="btnActionsClicked(this)" class="text-red-400 flex items-center justify-center space-x-2 border border-accent p-2 rounded hover:bg-primary50 hover:border-b-2 hover:shadow-md hover:scale-[.95] transform transition-all">
                    <i class="fas fa-trash">
                    </i>
                    <span>
                        Delete
                    </span>
                </button>
            </div>
        </div>

        <div class="h-[90%] relative overflow-y-auto container border-t-2 border-accent ">
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


                    <div onclick="rowClicked(this)" name="inventory_<?= $product['id'] ?>" id="inventory_<?= $product['id'] ?>" class="cursor-pointer flex items-center justify-around space-x-2 border-b p-1 py-2 hover:bg-primary30 hover:border-y-2 hover:border-accent hover:scale-x-105 hover:font-bold transform transition-all">

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
                        <a name="viewItem" href="./?page=inventory&id=<?= $product['id'] ?>" class="w-1/6 z-10 text-center p-2 px-4 font-light text-sm relative">
                            <i class="fas fa-caret-right hover:text-3xl hover:text-secondary transform transition-all"></i>
                        </a>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>
    </div>


<?php endif; ?>



<!-- MODALS -->
<?php
$res = isset($_GET['res']) ? $_GET['res'] : null;
switch ($res) {
    case 'updateitemsuccess':
        echo createModal(
            visible: true,
            title: "Update success.",
            message: "Product Item information has successfully update!"
        );
        break;
    case 'additemsuccess':
        echo createModal(
            visible: true,
            title: "Item Added.",
            message: "Product Item has been added to the inventory!"
        );
        break;
    case 'deleteconfirm':
        $id = $_GET['id'];
        echo createModal(
            title: "Confirm Delete.",
            message: "Are you sure you want to delete this item?",
            visible: true,
            btnConfirm: "Delete",
            btnFunc: "window.location.replace('./inventory/delete.php?id=$id')"
        );
        break;
    case 'deleteitemsuccess':
        echo createModal(
            visible: true,
            title: "Item Deleted.",
            message: "Product Item has been deleted from the inventory!"
        );
        break;
    case 'updateitemerror':
        echo createModal(
            visible: true,
            title: "Update Error.",
            message: "There was an error while updating an item!"
        );
        break;
    case 'additemfailed':
        echo createModal(
            visible: true,
            title: "Item Add Failed.",
            message: "There was an error while adding an item!"
        );
        break;
    case 'deleteitemfailed':
        echo createModal(
            visible: true,
            title: "Item Delete Failed.",
            message: "There was an error while deleting an item!"
        );
        break;

    default:
        # code...
        break;
}
?>


<!-- CREATE MODAL -->


<div class="<?= isset($_GET['mode']) && $_GET['mode'] == 'create' ? '' : 'hidden' ?> fixed z-10 top-0 w-full left-0  overflow-y-auto" id="alert_modal">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-900 opacity-20" />
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">
            &#8203;
        </span>

        <div class="h-full inline-block align-center py-8 transform transition-all align-middle w-full max-w-xl p-2">
            <form enctype="multipart/form-data" action="./inventory/add.php" method="post" id="modal-content" class="animate-fall relative container flex flex-col justify-between rounded-lg overflow-y-auto shadow-xl p-4 border border-accent30 bg-white text-left h-full min-h-full">
                <div class="container h-full max-h-full overflow-y-auto">

                    <!-- Title -->
                    <div class="flex items-center space-x-4 p-2 px-4 border-b-2 border-accent">
                        <i class="text-xl md:text-3xl text-accent fas fa-plus"></i>
                        <h1 class="text-xl md:text-3xl font-semibold text-accent hover:text-secondary">
                            Add New Product
                        </h1>
                    </div>

                    <div class="container p-2 px-4 flex flex-col space-y-4  text-md">

                        <!-- Name Input -->
                        <div class="w-full flex flex-col space-y-2 md:space-y-0 md:items-center md:justify-between md:flex-row md:space-x-2">
                            <span class="w-[40%]">Item Name: </span>
                            <input required type="text" name="item_name" id="item_name" placeholder="Add item name" class="w-full border rounded p-1 px-4">
                        </div>

                        <!-- Item Price -->
                        <div class="w-full flex flex-col space-y-2 md:space-y-0 md:items-center md:justify-between md:flex-row md:space-x-2">
                            <span class="w-[40%]">Item Price: </span>
                            <input required type="number" step="any" name="price" id="price" placeholder="0" class="w-full border rounded p-1 px-4">
                        </div>

                        <!-- Qty -->
                        <div class="w-full flex flex-col space-y-2 md:space-y-0 md:items-center md:justify-between md:flex-row md:space-x-2">
                            <span class="w-[40%]">Stock Quantity: </span>
                            <input required type="number" name="stock_quantity" id="stock_quantity" placeholder="0" class="w-full border rounded p-1 px-4">
                        </div>

                        <!-- Brand -->
                        <div class="w-full flex flex-col space-y-2 md:space-y-0 md:items-center md:justify-between md:flex-row md:space-x-2">
                            <span class="w-[40%]">Item Brand: </span>
                            <input required class="w-full border rounded p-1 px-4" list="item_brands" id="dropdown_brand" name="brand" value="">
                            <datalist id="item_brands">
                                <?php foreach ($brands as $brand) : ?>
                                    <option value="<?= $brand['brand'] ?>">
                                    <?php endforeach; ?>
                            </datalist>
                        </div>

                        <!-- Supplier -->
                        <div class="w-full flex flex-col space-y-2 md:space-y-0 md:items-center md:justify-between md:flex-row md:space-x-2">
                            <span class="w-[40%]">Item Supplier: </span>
                            <select required class="w-full border rounded p-1 px-4" id="dropdown_supplier" name="supplier">
                                <option value="" selected></option>
                                <?php foreach ($suppliers as $s) : ?>
                                    <option value="<?= $s['id'] ?>"><?= $s['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Description -->
                        <div class="w-full flex flex-col space-y-2 md:space-y-0 md:items-start md:justify-between md:flex-row md:space-x-2">
                            <span class="w-[40%]">Description: </span>
                            <textarea class="resize-none w-full border rounded p-1 px-4" name="description" id="productdesc" rows="3">Add description... </textarea>
                        </div>

                        <!-- Images -->
                        <div class="w-full flex flex-col space-y-2 items-center">
                            <label for="images" class="w-full text-center rounded border border-accent p-2 hover:scale-105 hover:border-b-2 transition-all transform">
                                <i class="fas fa-plus"></i> Add Images
                            </label>
                            <input onchange="handleFileSelect(event)" type="file" name="images[]" id="images" class="hidden" multiple />
                        </div>


                        <!-- Image Display -->
                        <div id="imageDisplay" class="w-full grid grid-cols-1 md:grid-cols-3 gap-4">
                        </div>
                    </div>

                </div>

                <!-- option buttons -->
                <div class="flex items-center justify-end space-x-4 w-full">
                    <a name="closeModal" class="px-4 py-2 bg-secondary30 text-accent border border-accent rounded hover:bg-red-400" href="./?page=inventory">Close</a>

                    <button type="submit" name="confirmModal" class="px-4 py-2 bg-primary50 text-accent border border-accent rounded hover:bg-green-400" onclick="">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php if (empty($products)) : ?>
    <script>
        window.location.replace("./?page=inventory&res=searchnotfound");
    </script>
<?php endif; ?>