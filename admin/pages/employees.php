<?php

session_start();

$status = $_GET['status'];
$query = <<<SQL

SELECT 
u.id,
u.username,
CONCAT(u.first_name, ' ', u.middle_name,' ', u.last_name) as 'name',
u.email,
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
} catch (Exception $ex) {
    echo $ex->getMessage();
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

<div class="container border-t-2 border-accent ">
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


            <div name="user_<?= $user['id'] ?>" id="user_<?= $user['id'] ?>" class="flex items-center justify-around space-x-2 border-b  p-1 py-2 hover:bg-primary30 hover:border-b-2 hover:border-accent hover:scale-x-105 hover:font-bold transform transition-all">

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
                <p class="w-1/6 text-center font-light text-sm">
                    <i class="fas fa-caret-right"></i>
                </p>
            </div>
        <?php endforeach; ?>

    </div>
</div>