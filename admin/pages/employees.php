<?php

session_start();

$id = $_GET['id'];


$query = <<<SQL

SELECT 
u.*,
CONCAT(u.first_name, ' ', u.middle_name,' ', u.last_name) as 'name',
r.name as 'role',
d.name as 'department'

FROM 
user as u

INNER JOIN `role` as r
ON u.role_id = r.id

INNER JOIN department as d
ON u.department_id = d.id


SQL;
try {

    $dbc = new DatabaseConfig();

    $users = $dbc->executeQuery(
        $query
    );
    $roles = $dbc->select('role');
    $departments = $dbc->select('department');
} catch (Exception $ex) {
    echo $ex->getMessage();
}


?>


<?php if (!empty($_GET['id']) && $id > -1 && $_GET['mode'] != 'edit') : ?>
    <?php
    $user = $users[0];
    ?>

    <div class="container flex flex-col space-y-4 h-full">

        <!-- Title -->
        <div class="w-full flex items-center space-x-4 pb-4 border-b-2 border-accent">
            <i class="fas fa-box text-3xl text-accent"></i>
            <h1 class="text-xl md:text-3xl font-bold text-accent hover:text-secondary">
                Employee View
            </h1>
        </div>

        <div class="container flex space-x-4  h-full rounded">
            <div class="w-1/3 flex flex-col items-center space-y-4 h-screen">

                <!-- Images -->
                <div class="p-4 flex flex-col items-center justify-center space-y-4 border border-accent rounded w-full">
                    <h3 class="w-full">Employee Image</h3>
                    <div class="flex items-center justify-center aspect-square w-full border border-accent rounded p-4">
                        <img src="../img/user/user_39.jpg" alt=" " class="object-contain aspect-square">
                    </div>
                </div>

                <!-- Action buttons -->
                <div class="p-4 w-full h-1/4 flex flex-col space-y-4 ">
                    <a href="./?page=employees&id=<?= $id ?>&mode=edit" class="w-full text-center rounded border border-accent p-2 bg-primary50 hover:scale-110 hover:border-b-2 transition-all transform">
                        Edit Information
                    </a>
                    <a href="./?page=employees&id=<?= $id ?>&res=deleteconfirm" class="text-center w-full rounded border border-accent p-2 bg-red-300 hover:scale-110 hover:border-b-2 transition-all transform">
                        Delete
                    </a>
                </div>
            </div>

            <!-- Employee Information -->
            <div class="w-2/3 flex flex-col space-y-4 h-full">
                <div class=" flex space-x-2 items-center border-b-2 py-4">
                    <i class="text-accent fas fa-info bg-primary30 aspect-square border border-accent p-1 rounded-full">
                    </i>
                    <h3 class="text-md font-medium">Employee Information</h3>
                </div>

                <div class=" flex-col space-y-2 items-center">

                    <!-- Id -->
                    <div class="flex space-x-4 items-center">
                        <p>Employee Id:</p>
                        <h1 class="text-xl font-light">
                            000<?= $user['id'] ?>
                        </h1>
                    </div>


                    <!-- Name -->
                    <div class="flex space-x-4">
                        <div class="flex flex-col ">
                            <label class="text-sm text-gray-400" for="first_name">First Name</label>
                            <input disabled class="text-md" type="text" name="first_name" id="first_name" value="<?= $user['first_name'] ?>">
                        </div>
                        <div class="flex flex-col ">
                            <label class="text-sm  text-gray-400" for="middle_name">Middle Name</label>
                            <input disabled class="text-md" type="text" name="middle_name" id="middle_name" value="<?= $user['middle_name'] ?>">
                        </div>
                        <div class="flex flex-col ">
                            <label class="text-sm text-gray-400" for="last_name">Last Name</label>
                            <input disabled class="text-md" type="text" name="last_name" id="last_name" value="<?= $user['last_name'] ?>">
                        </div>
                    </div>

                    <!-- Credentials -->
                    <div class="flex justify-between">
                        <div class="w-1/2  flex flex-col">
                            <label class="text-sm text-gray-400" for="username">Username</label>
                            <input disabled class="pr-8 text-lg" type="text" name="username" id="username" value="<?= $user['username'] ?>">
                        </div>
                        <div class="w-1/2 flex flex-col">
                            <label class="text-sm text-gray-400" for="email">Email</label>
                            <input disabled class="pr-8 text-lg" type="email" name="email" id="email" value="<?= $user['email'] ?>">
                        </div>
                    </div>

                    <!-- Roles -->
                    <div class="flex pb-8 justify-between">
                        <div class="w-1/2 pr-8 flex flex-col space-y-1">
                            <label class="text-sm text-gray-400" for="role">Role</label>
                            <select disabled class="py-2" id="role" name="role">
                                <?php foreach ($roles as $r) : ?>
                                    <option value="<?= $r['id'] ?>"><?= $r['name'] ?></option>
                                <?php endforeach; ?>
                            </select>

                        </div>
                        <div class="w-1/2 pr-8 flex flex-col space-y-1">
                            <label class="text-sm text-gray-400" for="role">Department</label>
                            <select disabled class="py-2" id="role" name="department">
                                <?php foreach ($departments as $d) : ?>
                                    <option value="<?= $d['id'] ?>"><?= $d['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="py-8 flex flex-col border-t-2 border-accent">
                        <label class="text-sm text-gray-400" for="address">Address</label>
                        <input disabled class="pr-8 text-lg" type="text" name="address" id="address" value="<?= $user['address'] ?>">
                    </div>
                    <!-- Personal info -->
                    <div class="pt-8 border-t-2 border-accent flex">
                        <div class="flex flex-col">
                            <label class="text-sm text-gray-400" for="phone_number">Phone Number</label>
                            <input disabled class="pr-4  text-lg" type="text" name="phone_number" id="phone_number" value="<?= $user['phone_number'] ?>">
                        </div>
                        <div class="flex justify-between items-center w-full">
                            <div class="flex flex-col">
                                <label class="text-sm text-gray-400" for="birthday">Birthday</label>
                                <input disabled class=" text-lg" type="date" name="birthdate" id="birthdate" value="<?= $user['birthdate'] ?>">
                            </div>
                            <div class="flex flex-col">
                                <label class="text-sm text-gray-400" for="age">Age</label>
                                <input disabled class="text-lg" type="number" name="age" id="age" value="<?= $user['age'] ?>">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


<?php elseif (!empty($_GET['id']  && $id > -1) && $_GET['mode'] == 'edit') : ?>


    <?php
    $user = $users[0];
    ?>

    <div class="container flex flex-col space-y-4 h-full">

        <!-- Title -->
        <div class="w-full flex items-center space-x-4 pb-4 border-b-2 border-accent">
            <i class="fas fa-box text-3xl text-accent"></i>
            <h1 class="text-xl md:text-3xl font-bold text-accent hover:text-secondary">
                Edit Employee
            </h1>
        </div>

        <form enctype="multipart/form-data" method="post" action="./employee/update.php?id=<?= $user ?>" class="container flex space-x-4  h-full rounded">
            <div class="w-1/3 flex flex-col items-center space-y-4 h-screen">

                <!-- Images -->
                <div class="p-4 flex flex-col items-center justify-center space-y-4 border border-accent rounded w-full">
                    <h3 class="w-full">Employee Image</h3>
                    <div class="flex items-center justify-center aspect-square w-full border border-accent rounded p-4">
                        <img src="../img/user/user_39.jpg" alt=" " class="object-contain aspect-square">
                    </div>
                    <div class="flex flex-col space-y-4">
                        <label for="images" class="w-full text-center rounded border border-accent p-2 bg-primary50 hover:scale-110 hover:border-b-2 transition-all transform">
                            Upload Image
                        </label>
                        <input type="file" name="images[]" id="images" class="hidden" multiple accept="image/*" />
                    </div>
                </div>

                <!-- Action buttons -->
                <div class="p-4 w-full h-1/4 flex flex-col space-y-4 ">
                    <button type="submit" name="action" value="update" class="w-full text-center rounded border border-accent p-2 bg-primary50 hover:scale-110 hover:border-b-2 transition-all transform">
                        Save
                    </button>
                    <a href="./?page=employees&id=<?= $id ?>" class="text-center w-full rounded border border-accent p-2 bg-red-300 hover:scale-110 hover:border-b-2 transition-all transform">
                        Cancel
                    </a>
                </div>
            </div>

            <!-- Employee Information -->
            <div class="w-2/3 flex flex-col space-y-4 h-full">
                <div class=" flex space-x-2 items-center border-b-2 py-4">
                    <i class="text-accent fas fa-info bg-primary30 aspect-square border border-accent p-1 rounded-full">
                    </i>
                    <h3 class="text-md font-medium">Edit Information</h3>
                </div>

                <div class=" flex-col space-y-2 items-center">

                    <!-- Id -->
                    <div class="flex space-x-4 items-center">
                        <p>Employee Id:</p>
                        <input class="text-md" type="text" name="id" id="id" value="<?= $user['id'] ?>" hidden>

                        <h1 class="text-xl font-light">
                            000<?= $user['id'] ?>
                        </h1>
                    </div>


                    <!-- Name -->
                    <div class="flex space-x-4 ">
                        <div class="flex flex-col ">
                            <label class="text-sm text-gray-400" for="first_name">First Name</label>
                            <input class="text-md" type="text" name="first_name" id="first_name" value="<?= $user['first_name'] ?>">
                        </div>
                        <div class="flex flex-col ">
                            <label class="text-sm  text-gray-400" for="middle_name">Middle Name</label>
                            <input class="text-md" type="text" name="middle_name" id="middle_name" value="<?= $user['middle_name'] ?>">
                        </div>
                        <div class="flex flex-col ">
                            <label class="text-sm text-gray-400" for="last_name">Last Name</label>
                            <input class="text-md" type="text" name="last_name" id="last_name" value="<?= $user['last_name'] ?>">
                        </div>
                    </div>

                    <!-- Credentials -->
                    <div class="flex justify-between">
                        <div class="w-1/2 pr-8  flex flex-col">
                            <label class="text-sm text-gray-400" for="username">Username</label>
                            <input class="text-lg" type="text" name="username" id="username" value="<?= $user['username'] ?>">
                        </div>
                        <div class="w-1/2 pr-8 flex flex-col">
                            <label class="text-sm text-gray-400" for="email">Email</label>
                            <input class="text-lg" type="email" name="email" id="email" value="<?= $user['email'] ?>">
                        </div>
                    </div>

                    <!-- Roles -->
                    <div class="flex pb-8 justify-between">
                        <div class="w-1/2 pr-8 flex flex-col space-y-1">
                            <label class="text-sm text-gray-400" for="role">Role</label>
                            <select class="py-2" id="role" name="role">
                                <?php foreach ($roles as $r) : ?>
                                    <option value="<?= $r['id'] ?>"><?= $r['name'] ?></option>
                                <?php endforeach; ?>
                            </select>

                        </div>
                        <div class="w-1/2  pr-8  flex flex-col space-y-1">
                            <label class="text-sm text-gray-400" for="department">Department</label>
                            <select class="py-2" id="department" name="department">
                                <?php foreach ($departments as $d) : ?>
                                    <option value="<?= $d['id'] ?>"><?= $d['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="py-8 flex flex-col border-t-2 border-accent">
                        <label class="text-sm text-gray-400" for="address">Address</label>
                        <input class="pr-8 text-lg" type="text" name="address" id="address" value="<?= $user['address'] ?>">
                    </div>
                    <!-- Personal info -->
                    <div class="pt-8 border-t-2 border-accent flex">
                        <div class="pr-8  flex flex-col">
                            <label class="text-sm text-gray-400" for="phone_number">Phone Number</label>
                            <input class="  text-lg" type="text" name="phone_number" id="phone_number" value="<?= $user['phone_number'] ?>">
                        </div>
                        <div class="flex justify-between items-center w-full">
                            <div class="flex flex-col">
                                <label class="text-sm text-gray-400" for="birthday">Birthday</label>
                                <input class=" text-lg" type="date" name="birthdate" id="birthdate" value="<?= $user['birthdate'] ?>">
                            </div>
                            <div class="flex flex-col">
                                <label class="text-sm text-gray-400" for="age">Age</label>
                                <input class="`text-lg" type="number" name="age" id="age" value="<?= $user['age'] ?>">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>



<?php else : ?>

    <div class="h-full overflow-y-hidden flex container flex-col space-y-4">

        <!-- BUTTONS -->
        <div class="container flex items-center justify-between">
            <h3>Selected Item: <span id="selectedItemId">_</span> </h3>
            <div class="flex justify-end space-x-4 px-4 text-sm">
                <button id="create_employees" name="create_employees" onclick="btnActionsClicked(this)" class="flex items-center justify-center space-x-2 border border-accent p-2 rounded hover:bg-primary50 hover:border-b-2 hover:shadow-md hover:scale-[.95] transform transition-all">
                    <i class="fas fa-plus">
                    </i>
                    <span>
                        Add New
                    </span>
                </button>
                <button id="edit_employees" name="edit_employees" onclick="btnActionsClicked(this)" class="flex items-center justify-center space-x-2 border border-accent p-2 rounded hover:bg-primary50 hover:border-b-2 hover:shadow-md hover:scale-[.95] transform transition-all">
                    <i class="fas fa-pen">
                    </i>
                    <span>
                        Edit
                    </span>
                </button>
                <button id="delete_employees" name="delete_employees" onclick="btnActionsClicked(this)" class="text-red-400 flex items-center justify-center space-x-2 border border-accent p-2 rounded hover:bg-primary50 hover:border-b-2 hover:shadow-md hover:scale-[.95] transform transition-all">
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
                    <h3 class="w-1/6 text-left text-ellipsis font-semibold text-sm">
                        Username
                    </h3>
                    <h3 class="w-1/6 text-left text-ellipsis font-semibold text-sm">
                        Name
                    </h3>
                    <h3 class="w-1/6 text-left text-ellipsis font-semibold text-sm">
                        Email
                    </h3>
                    <h3 class="w-1/6 text-center text-ellipsis font-semibold text-sm">
                        Role
                    </h3>
                    <h3 class="w-1/6 text-center text-ellipsis font-semibold text-sm">
                        Department
                    </h3>
                    <h3 class="w-1/6 text-center text-ellipsis font-semibold text-sm">
                        &nbsp;
                    </h3>
                </div>

                <?php foreach ($users as $user) : ?>


                    <div onclick="rowClicked(this)" name="employees_<?= $user['id'] ?>" id="employees_<?= $user['id'] ?>" class="flex items-center justify-around space-x-2 border-b  p-1 py-2 hover:bg-primary30 hover:border-y-2 hover:border-accent hover:scale-x-105 hover:font-bold transform transition-all">

                        <!-- ID -->
                        <p class="w-1/6 text-center text-ellipsis font-light text-sm">
                            <?= $user['id'] ?>
                        </p>

                        <!-- username -->
                        <p class="w-1/6 text-left text-ellipsis font-light text-sm">
                            <?= $user['username'] ?>
                        </p>

                        <!-- name  -->
                        <p class="w-1/6 text-left text-ellipsis font-light text-sm">
                            <?= $user['name'] ?>
                        </p>

                        <!-- email -->
                        <p class="w-1/6 max-w-full overflow-hidden text-ellipsis break-words text-left font-light text-sm">
                            <?= wordwrap($user['email'], 13, '<br>', true) ?>
                        </p>

                        <!-- role -->
                        <p class="w-1/6 text-center text-ellipsis font-light text-sm">
                            <?= $user['role'] ?>
                        </p>
                        <!-- department -->
                        <p class="w-1/6 text-center text-ellipsis font-light text-sm">
                            <?= $user['department'] ?>
                        </p>

                        <!-- View More -->
                        <a name="viewItem" href="./?page=employees&id=<?= $user['id'] ?>" class="w-1/6 z-10 text-center p-2 px-4 font-light text-sm relative">
                            <i class="fas fa-caret-right hover:text-3xl hover:text-secondary transform transition-all"></i>
                        </a>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>

    </div>

<?php endif; ?>






<!-- Modals -->

<!-- Create Modal -->
<?php
include_once '../../components/modals.php';

switch ($_GET['res']) {
    case 'employeeupdatesuccess':
        echo createModal(
            visible: true,
            title: 'Employee Update Success',
            message: 'Employee has been updated successfully.',
        );
        break;
    case 'employeedeletesuccess':
        echo createModal(
            visible: true,
            title: 'Employee Delete Success',
            message: 'Employee has been deleted successfully.',
        );
        break;
    case 'employeecreatesuccess':
        echo createModal(
            visible: true,
            title: 'Employee Create Success',
            message: 'Employee has been created successfully.',
        );
        break;
    case 'deleteconfirm':
        $id = $_GET['id'];
        echo createModal(
            title: "Confirm Delete.",
            message: "Are you sure you want to delete this employee account?",
            visible: true,
            btnConfirm: "Delete",
            btnFunc: "window.location.replace('./employee/delete.php?id=$id')"
        );
        break;


    default:
        break;
}

?>





<!-- Create user Modal -->


<!-- CREATE MODAL -->


<div class="<?= $_GET['mode'] == 'create' ? '' : 'hidden' ?> fixed z-10 top-0 w-full left-0  overflow-y-auto" id="alert_modal">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-900 opacity-20" />
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">
            &#8203;
        </span>

        <div class="h-full inline-block align-center py-8 transform transition-all align-middle w-full max-w-2xl p-2">
            <form enctype="multipart/form-data" action="./employee/add.php" method="post" id="modal-content" class="animate-fall relative container flex flex-col justify-between rounded-lg overflow-y-auto shadow-xl p-4 border border-accent30 bg-white text-left h-full min-h-full">
                <div class="container h-full max-h-full overflow-y-auto">

                    <!-- Title -->
                    <div class="flex items-center space-x-4 p-2 px-4 border-b-2 border-accent">
                        <i class="text-xl md:text-3xl text-accent fas fa-plus"></i>
                        <h1 class="text-xl md:text-3xl font-semibold text-accent hover:text-secondary">
                            Add New Employee
                        </h1>
                    </div>

                    <div class="container p-2 px-4 flex flex-col space-y-4  text-md">

                        <!-- Name Input -->
                        <div class="w-full flex flex-col space-y-2 ">
                            <span class="w-[40%]">Empoyee Name: </span>
                            <div class="flex flex-col space-y-2 items-center justify-around md:space-y-0 md:flex-row md:space-x-2">
                                <input required type="text" name="first_name" id="first_name" placeholder="First" class="w-full border rounded p-1 px-4">
                                <input required type="text" name="middle_name" id="middle_name" placeholder="Middle" class="w-full border rounded p-1 px-4">
                                <input required type="text" name="last_name" id="last_name" placeholder="Last" class="w-full border rounded p-1 px-4">
                            </div>
                        </div>

                        <!-- Username -->
                        <div class="w-full flex flex-col space-y-2 md:space-y-0 md:items-center md:justify-between md:flex-row md:space-x-2">
                            <span class="w-[40%]">Username: </span>
                            <input required type="text" name="username" id="username" placeholder="Username" class="w-full border rounded p-1 px-4">
                        </div>

                        <!-- Email -->
                        <div class="w-full flex flex-col space-y-2 md:space-y-0 md:items-center md:justify-between md:flex-row md:space-x-2">
                            <span class="w-[40%]">Email: </span>
                            <input required type="email" name="email" id="email" placeholder="Email Address" class="w-full border rounded p-1 px-4">
                        </div>

                        <!-- Role -->
                        <div class="w-full flex flex-col space-y-2 md:space-y-0 md:items-center md:justify-between md:flex-row md:space-x-2">
                            <label class="w-[40%] text-s" for="role">Role</label>
                            <select class="container p-2 px-4" id="role" name="role">
                                <?php foreach ($roles as $r) : ?>
                                    <option value="<?= $r['id'] ?>"><?= $r['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Department -->
                        <div class="w-full flex flex-col space-y-2 md:space-y-0 md:items-center md:justify-between md:flex-row md:space-x-2">
                            <label class="w-[40%] text-sm " for="department">Department</label>
                            <select class="container px-4 py-2" id="department" name="department">
                                <?php foreach ($departments as $d) : ?>
                                    <option value="<?= $d['id'] ?>"><?= $d['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Description -->
                        <div class="w-full flex flex-col space-y-2 md:space-y-0 md:items-start md:justify-between md:flex-row md:space-x-2">
                            <span class="w-[40%]">Address: </span>
                            <textarea class="resize-none w-full border rounded p-1 px-4" name="address" id="address" rows="3">Add employee address. </textarea>
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
                    <a name="closeModal" class="px-4 py-2 bg-secondary30 text-accent border border-accent rounded hover:bg-red-400" href="./?page=employees">Close</a>

                    <button type="submit" name="action" value="create" class="px-4 py-2 bg-primary50 text-accent border border-accent rounded hover:bg-green-400" onclick="">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>