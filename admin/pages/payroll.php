<?php

session_start();

$status = $_GET['status'];
$query = <<<SQL

SELECT 

    u.id,
    u.username,
    CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name) as employee,
    s.id as salary_id,
    uhs.payGrade as pay_grade,
    s.hoursWorked as hours_worked,
    s.net_amount as net_value

FROM
    user as u

    INNER JOIN user_has_salary as uhs ON u.id = uhs.user_id
    INNER JOIN salary as s ON s.id = uhs.salary_id
    INNER JOIN benefits as b ON b.id = s.benefits_id

SQL;
try {

    $dbc = new DatabaseConfig();

    $users = $dbc->executeQuery(
        $query
    );

    $employees = $dbc->executeQuery(
        "SELECT id, CONCAT(first_name, ' ', middle_name, ' ', last_name) as `name`, username FROM user"
    );
} catch (Exception $ex) {
    echo $ex->getMessage();
}


?>

<?php if ($_GET['id'] > 0) : ?>
<?php elseif ($_GET['mode'] == 'edit' && $_GET['id'] > 0) : ?>
<?php else : ?>

    <div class="flex container flex-col space-y-4 h-full overflow-y-hidden">

        <!-- BUTTONS -->
        <div class="h-[90%] relative overflow-y-auto  container flex items-center justify-between">
            <h3>Selected Item: <span id="selectedItemId">_</span> </h3>
            <div class="flex justify-end space-x-4 px-4 text-sm">
                <button id="create_payroll" name="create_payroll" onclick="btnActionsClicked(this)" class="flex items-center justify-center space-x-2 border border-accent p-2 rounded hover:bg-primary50 hover:border-b-2 hover:shadow-md hover:scale-[.95] transform transition-all">
                    <i class="fas fa-plus">
                    </i>
                    <span>
                        Add New
                    </span>
                </button>
                <button id="edit_payroll" name="edit_payroll" onclick="btnActionsClicked(this)" class="flex items-center justify-center space-x-2 border border-accent p-2 rounded hover:bg-primary50 hover:border-b-2 hover:shadow-md hover:scale-[.95] transform transition-all">
                    <i class="fas fa-pen">
                    </i>
                    <span>
                        Edit
                    </span>
                </button>
                <button id="delete_payroll" name="delete_payroll" onclick="btnActionsClicked(this)" class="text-red-400 flex items-center justify-center space-x-2 border border-accent p-2 rounded hover:bg-primary50 hover:border-b-2 hover:shadow-md hover:scale-[.95] transform transition-all">
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
                    <h3 class="w-1/6 text-left text-ellipsis font-semibold text-sm">
                        Username
                    </h3>
                    <h3 class="w-1/6 text-left text-ellipsis font-semibold text-sm">
                        Employee
                    </h3>
                    <h3 class="w-1/6 text-center text-ellipsis font-semibold text-sm">
                        Paygrade
                    </h3>
                    <h3 class="w-1/6 text-center text-ellipsis font-semibold text-sm">
                        Hours Worked
                    </h3>
                    <h3 class="w-1/6 text-center text-ellipsis font-semibold text-sm">
                        Net Income
                    </h3>
                    <h3 class="w-1/6 text-center text-ellipsis font-semibold text-sm">
                        &nbsp;
                    </h3>
                </div>

                <?php foreach ($users as $user) : ?>


                    <div onclick="rowClicked(this)" name="payroll_<?= $user['id'] ?>" id="payroll_<?= $user['id'] ?>" class="flex items-center justify-around space-x-2 border-b  p-1 py-2 hover:bg-primary30 hover:border-y-2 hover:border-accent hover:scale-x-105 hover:font-bold transform transition-all">

                        <!-- ID -->
                        <p class="w-1/6 text-center text-ellipsis font-light text-sm">
                            <?= $user['id'] ?>
                        </p>

                        <!-- Username -->
                        <p class="w-1/6 text-left text-ellipsis font-light text-sm">
                            <?= $user['username'] ?>
                        </p>

                        <!-- employee  -->
                        <p class="w-1/6 text-left text-ellipsis font-light text-sm">
                            <?= $user['employee'] ?>
                        </p>

                        <!-- pay_grade -->
                        <p class="w-1/6 text-center text-ellipsis font-light text-sm">
                            <?= $user['pay_grade'] ?>

                        </p>

                        <!-- hw -->
                        <p class="w-1/6 text-center text-ellipsis font-light text-sm">
                            <?= $user['hours_worked'] ?>
                        </p>
                        <!-- net -->
                        <p class="w-1/6 text-center text-ellipsis font-light text-sm">
                            <?= $user['net_value'] ?>
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



<!-- CREATE NEW PAYROLL -->

<div class="<?= $_GET['mode'] == 'create' ? '' : '' ?> fixed z-10 top-0 w-full left-0  overflow-y-auto" id="alert_modal">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-900 opacity-20" />
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">
            &#8203;
        </span>

        <div class="h-full inline-block align-center py-8 transform transition-all align-middle w-full max-w-xl p-2">
            <form action="./payroll/add.php" method="post" id="modal-content" class="animate-fall relative container flex flex-col justify-between rounded-lg overflow-y-auto shadow-xl p-4 border border-accent30 bg-white text-left h-full min-h-full">
                <div class="container h-full max-h-full overflow-y-auto">

                    <!-- Title -->
                    <div class="flex items-center space-x-4 p-2 px-4 border-b-2 border-accent">
                        <i class="text-xl md:text-3xl text-accent fas fa-plus"></i>
                        <h1 class="text-xl md:text-3xl font-semibold text-accent hover:text-secondary">
                            Create New Payroll
                        </h1>
                    </div>

                    <div class="container p-2 px-4 flex flex-col space-y-4  text-md">

                        <!-- Name Input -->
                        <div class="w-full flex flex-col space-y-2 md:space-y-0 md:items-center md:justify-between md:flex-row md:space-x-2">
                            <span class="w-[40%]">Employee: </span>
                            <select required class="w-full border rounded p-1 px-4" id="dropdown_supplier" name="supplier">
                                <option value="" selected></option>
                                <?php foreach ($employees as $e) : ?>
                                    <option value="<?= $e['id'] ?>"><?= $e['name'] ?></option>
                                <?php endforeach; ?>
                            </select>



                        </div>

                        <!-- Work Hourse -->
                        <div class="w-full flex flex-col space-y-2 md:space-y-0 md:items-center md:justify-between md:flex-row md:space-x-2">
                            <span class="w-[40%]">Work Hours: </span>
                            <input required type="number" step="any" name="hoursWorked" id="hoursWorked" placeholder="0" class="w-full border rounded p-1 px-4">
                        </div>

                        <!-- Pay Grade -->
                        <div class="w-full flex flex-col space-y-2 md:space-y-0 md:items-center md:justify-between md:flex-row md:space-x-2">
                            <span class="w-[40%]">Pay Grade: </span>
                            <input required type="number" step="any" name="payGrade" id="payGrade" placeholder="0" class="w-full border rounded p-1 px-4">
                        </div>

                        <!-- Gross -->
                        <div class="w-full flex flex-col space-y-2 md:space-y-0 md:items-center md:justify-between md:flex-row md:space-x-2">
                            <span class="w-[40%]">Gross Amount: </span>
                            <input disabled type="number" step="any" name="gross_amount" id="gross_amount" placeholder="0" class="w-full border rounded p-1 px-4">
                        </div>
                        <!-- Net Amount -->
                        <div class="w-full flex flex-col space-y-2 md:space-y-0 md:items-center md:justify-between md:flex-row md:space-x-2">
                            <span class="w-[40%]">Net Amount: </span>
                            <input disabled type="number" step="any" name="net_amount" id="net_amount" placeholder="0" class="w-full border rounded p-1 px-4">
                        </div>

                        <!-- Calculations -->
                        <div class="w-full flex flex-col space-y-2">

                            <!-- Total -->
                            <div class="w-full flex flex-col space-y-2 md:space-y-0 md:items-center md:justify-between md:flex-row md:space-x-2">
                                <span class="w-[40%]">Total: </span>
                                <input disabled type="number" step="any" name="total" id="total" placeholder="0" class="w-full border rounded p-1 px-4">
                            </div>

                        </div>




                    </div>

                </div>

                <!-- option buttons -->
                <div class="flex items-center justify-between space-x-8 w-full">

                    <button type="button" name="calculate" id="calculate" class="w-full px-4 py-2 bg-primary50 text-accent border border-accent rounded hover:bg-green-400">
                        Calculate
                    </button>

                    <div class="flex items-center space-x-4 ">

                        <a name="closeModal" class="px-4 py-2 bg-secondary30 text-accent border border-accent rounded hover:bg-red-400" href="./?page=inventory">Close</a>

                        <button type="submit" name="confirmModal" class="px-4 py-2 bg-primary50 text-accent border border-accent rounded hover:bg-green-400" onclick="">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- END -->




<!-- Modals -->