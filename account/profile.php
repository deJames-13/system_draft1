<?php
session_start();
if (empty($_SESSION['newUser']) && empty($_SESSION['userName'])) {
    header('Location: ./signup.php');
    exit;
}

if ($_GET['viewprofile'] != 1) {
    header('Location: ../home/');
    exit;
}

$userName = $_SESSION['newUser']['username'];
$email = $_SESSION['newUser']['email'];
$isViewProfile = !empty($_SESSION['userId']) && $_GET['viewprofile'] == 1;
require_once '../scripts/db-config.php';
if ($_SESSION['userId']) {
    $dbc = new DatabaseConfig();
    $result = $dbc->select("customer", where: ["id" => $_SESSION['userId']])[0];
    $userName = $result['username'];
    $email = $result['email'];
    $firstName = $result['first_name'];
    $middleName = $result['middle_name'];
    $lastName = $result['last_name'];
    $phoneNumber = $result['phone_number'];
    $address = explode(",", $result['address']);
    $street_address = $address[0];
    $region = $address[1];
    $country = $address[2];
    $zip_code = $address[3];
    $$birthdate = $result['birthdate'];
    $age = $result['age'];
}





?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign In</title>

    <?php require_once '../scripts/links.php'; ?>
</head>

<body class="relative">

    <?php include_once '../components/header.php'; ?>

    <main>
        <div class="border p-6 my-12 flex items-center justify-center h-48 bg-cover bg-opacity-50 bg-center bg-no-repeat drop-shadow-lg lg:hidden" style="background-image: url(../img/sign-in-bg.png)">
            <h1 class="text-center self-center text-5xl text-white font-semibold drop-shadow-lg hover:text-primary hover:cursor-pointer hover:text-6xl hover:transition-all">
                YOUR PROFILE
            </h1>
        </div>

        <div class="flex flex-col items-center  w-auto pb-12">
            <h1 class="hidden pb-8 text-5xl text-accent font-semibold hover:text-secondary lg:text-6xl lg:block">
                YOUR PROFILE
            </h1>

            <!-- MAIN FORM -->
            <form method="post" action="./register.php" enctype="multipart/form-data" class=" container flex flex-col space-y-6 items-center w-full lg:flex-row lg:space-x-12 py-12 lg:py-0 lg:items-start">

                <!-- IMAGE -->
                <div class="border-accent border border-t-2 rounded py-8 container flex flex-col space-y-6 items-center justify-center lg:w-2/5">
                    <div class=" max-w-sm aspect-square container flex items-center justify-center p-4 shadow-xl lg:p-8 ">
                        <img src="../img/customer/customer_1.jpg" alt="" class=" max-w-xs object-contain aspect-square  shadow-lg">
                    </div>
                    <div class="w-full md:w-2/3 lg:w-2/3 flex flex-col space-y-2 items-center">

                        <input name="profile_image" id="profile_image" type="file" class="w-full border border-accent rounded-md p-2 px-4 text-lg bg-gray-100 focus:outline-none focus:border-accent hover: hover:bg-primary30 focus:bg-primary30" placeholder="Add Image" />
                        <label class="text-light" for="first_name">Select Profile Picture</label>
                    </div>
                </div>

                <!-- DETAILS -->
                <div class=" container flex flex-col space-y-6 items-center lg:w-3/5 lg:items-start">

                    <!-- NAME -->
                    <div class="container flex flex-col space-y-4 justify-around items-center lg:flex-row lg:space-y-0 lg:space-x-4">

                        <div class="w-full md:w-2/3 lg:w-1/3 flex flex-col space-y-2 items-start">
                            <label class="text-light" for="first_name">First Name</label>

                            <!-- First Name -->
                            <input name="first_name" id="first_name" type="text" class="w-full border-2 border-b-accent rounded-md p-1 text-md bg-gray-100 focus:outline-none focus:border-accent hover: hover:bg-primary30 focus:bg-primary30" placeholder="" required value="<?= $firstName ?>" />
                        </div>

                        <div class="w-full md:w-2/3 lg:w-1/3 flex flex-col space-y-2 items-start">
                            <label class="text-light" for="middle_name">Middle Name</label>

                            <!-- middle_name -->
                            <input name="middle_name" id="middle_name" type="text" class="w-full border-2 border-b-accent rounded-md p-1 text-md bg-gray-100 focus:outline-none focus:border-accent hover: hover:bg-primary30 focus:bg-primary30" placeholder="" value="<?= $middleName ?>" />
                        </div>

                        <div class="w-full md:w-2/3 lg:w-1/3 flex flex-col space-y-2 items-start">
                            <label class="text-light" for="last_name">Last Name</label>

                            <!-- last_name -->
                            <input name="last_name" id="last_name" type="text" class="w-full border-2 border-b-accent rounded-md p-1 text-md bg-gray-100 focus:outline-none focus:border-accent hover: hover:bg-primary30 focus:bg-primary30" placeholder="" required value="<?= $lastName ?>" />
                        </div>
                    </div>


                    <div class=" container flex flex-col space-y-4 justify-around items-center lg:flex-row lg:space-y-0 lg:space-x-4">

                        <div class="w-full md:w-2/3 lg:w-1/3 flex flex-col space-y-2 items-start">
                            <label class="text-light" for="username">Username</label>

                            <!-- username -->
                            <input name="username" id="username" type="text" class="w-full border-2 border-b-accent rounded-md p-1 text-md bg-gray-100 focus:outline-none focus:border-accent hover: hover:bg-primary30 focus:bg-primary30" placeholder="" required value="<?= $userName ?>" />
                        </div>

                        <div class="w-full md:w-2/3 lg:container flex flex-col space-y-2 items-start">
                            <label class="text-light" for="email">Email</label>

                            <!-- email -->
                            <input name="email" id="email" type="email" class="w-full border-2 border-b-accent rounded-md p-1 text-md bg-gray-100 focus:outline-none focus:border-accent hover: hover:bg-primary30 focus:bg-primary30" placeholder="" required value="<?= $email ?>" />
                        </div>
                    </div>

                    <div class="container md:w-2/3 max-w-2/3 lg:w-full flex flex-col space-y-2 items-start">
                        <label class="text-light" for="street_address">Street Address and City</label>

                        <!-- street_address -->
                        <input name="street_address" id="street_address" type="text" class="w-full border-2 border-b-accent rounded-md p-1 text-md bg-gray-100 focus:outline-none focus:border-accent hover: hover:bg-primary30 focus:bg-primary30" placeholder="" required value="<?= $street_address ?>" />
                    </div>


                    <div class="container flex flex-col space-y-4 justify-around items-center lg:flex-row lg:space-y-0 lg:space-x-4">

                        <div class="w-full md:w-2/3 lg:container flex flex-col space-y-2 items-start">
                            <label class="text-light" for="region">Province/Region</label>

                            <!-- region -->
                            <input name="region" id="region" type="text" class="w-full border-2 border-b-accent rounded-md p-1 text-md bg-gray-100 focus:outline-none focus:border-accent hover: hover:bg-primary30 focus:bg-primary30" placeholder="" required value="<?= $region ?>" />
                        </div>


                        <div class="w-full md:w-2/3 lg:container flex flex-col space-y-2 items-start">
                            <label class="text-light" for="country">Country</label>

                            <!-- country -->
                            <input name="country" id="country" type="text" class="w-full border-2 border-b-accent rounded-md p-1 text-md bg-gray-100 focus:outline-none focus:border-accent hover: hover:bg-primary30 focus:bg-primary30" placeholder="" required value="<?= $country ?>" />
                        </div>
                    </div>


                    <div class="container flex flex-col space-y-4 justify-around items-center lg:flex-row lg:space-y-0 lg:space-x-4">

                        <div class="w-full md:w-2/3 lg:container flex flex-col space-y-2 items-start">
                            <label class="text-light" for="zipcode">Zip Code</label>

                            <!-- zipcode -->
                            <input name="zipcode" id="zipcode" type="text" class="w-full border-2 border-b-accent rounded-md p-1 text-md bg-gray-100 focus:outline-none focus:border-accent hover: hover:bg-primary30 focus:bg-primary30" placeholder="" required value="<?= $zip_code ?>" />
                        </div>

                        <div class="w-full md:w-2/3 lg:container flex flex-col space-y-2 items-start">
                            <label class="text-light" for="contact_number">Contact Number</label>

                            <!-- contact_number -->
                            <input name="contact_number" id="contact_number" type="text" class="w-full border-2 border-b-accent rounded-md p-1 text-md bg-gray-100 focus:outline-none focus:border-accent hover: hover:bg-primary30 focus:bg-primary30" placeholder="" value="<?= $phoneNumber ?>" />
                        </div>
                    </div>


                    <div class="container flex flex-col space-y-4 items-center lg:flex-row lg:space-y-0 lg:space-x-4">


                        <div class="w-full md:w-2/3 lg:container flex flex-col space-y-2 items-start">
                            <label class="text-light" for="birthdate">Birthdate</label>

                            <!-- birthdate -->
                            <input name="birthdate" id="birthdate" type="date" class="w-full border-2 border-b-accent rounded-md p-1 text-md bg-gray-100 focus:outline-none focus:border-accent hover: hover:bg-primary30 focus:bg-primary30" placeholder="" value="<?= $birthdate ?>" />
                        </div>
                        <div class="h-full w-full md:w-2/3 lg:container flex flex-col space-y-2 items-start">
                            <label class="text-light" for="age">Age</label>

                            <!-- age -->
                            <input name="age" id="age" type="text" class="w-full border-2 border-b-accent rounded-md p-1 text-md bg-gray-100 focus:outline-none focus:border-accent hover: hover:bg-primary30 focus:bg-primary30" placeholder="" value="<?= $age ?>" />
                        </div>
                    </div>
                    <div class="container md:w-2/3 max-w-2/3 lg:w-full flex  space-x-2 items-center">
                        <!-- Btn Submit -->
                        <button name="action" type="Submit" class="<?= $isViewProfile ? '' : 'hidden' ?> w-full md:w-2/3 lg:w-1/2 border-2 border-accent text-center rounded-md p-2 px-4 text-lg bg-red-400 hover:bg-secondary50 focus:bg-primary30" placeholder="SUBMIT" value="<?= $isViewProfile ? 'deleteprofile' : '' ?>">Delete</button>


                        <button name="action" type="Submit" class="w-full md:w-2/3 lg:w-1/2 border-2 border-accent text-center rounded-md p-2 px-4 text-lg bg-green-400  hover:bg-secondary50 " placeholder="SUBMIT" value="<?= $isViewProfile ? 'updateprofile' : 'saveprofile' ?>">Save</button>
                    </div>
                </div>

            </form>

        </div>
    </main>
</body>

</html>