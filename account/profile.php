<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
if (empty($_SESSION['newUser']) && empty($_SESSION['userName'])) {
    header('Location: ./signup.php');
    exit;
}

if ($_GET['viewprofile'] != 1) {
    header('Location: ../home/');
    exit;
}

$userName = null;
$email  = null;
if (isset($_SESSION['newUser'])) {
    $userName = $_SESSION['newUser']['username'];
    $email = $_SESSION['newUser']['email'];
}


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
    $birthdate = $result['birthdate'];
    $age = $result['age'];
    $itemImage = $result['image_dir'];
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

<body class="relative text-accent">

    <?php include_once '../components/header.php'; ?>
    <?php include_once '../components/image-container.php'; ?>

    <main>
        <div class="border p-6 my-12 flex items-center justify-center h-48 bg-cover bg-opacity-50 bg-center bg-no-repeat drop-shadow-lg lg:hidden" style="background-image: url(../img/sign-in-bg.png)">
            <h1 class="text-center self-center text-5xl text-white font-semibold drop-shadow-lg hover:text-primary hover:cursor-pointer hover:text-6xl hover:transition-all">
                <?php echo $_SESSION['newUser'] ? 'SET UP ' : '' ?>
                YOUR PROFILE
            </h1>
        </div>

        <div class="flex flex-col items-center w-auto pb-12 p-2">
            <h1 class="hidden pb-8 text-accent font-semibold hover:text-secondary lg:text-6xl lg:block">
                <?php echo $_SESSION['newUser'] ? 'SET UP ' : '' ?>
                YOUR PROFILE
                <?php


                ?>
            </h1>

            <!-- MAIN FORM -->
            <form method="post" action="./register.php" enctype="multipart/form-data" class="border border-t-2 border-accent rounded mx-auto  flex flex-col space-y-6 items-center justify-center p-4 py-12 lg:px-12">

                <!-- IMAGE -->
                <div class="container max-w-lg flex flex-col space-y-8 items-center justify-center py-8">
                    <div class="max-w-xs aspect-square flex items-center justify-center shadow-xl ">

                        <!-- IMAGE CONTAIN -->
                        <div class="w-full relative ">
                            <div id="imageDisplay" class="overflow-auto max-w-full h-full flex transition-all transform aspect-square">

                                <?php showImageContainer($itemImage, "customer") ?>


                            </div>
                        </div>

                    </div>



                    <div class="flex flex-col space-y-2 items-center">

                        <label id="selectImageClicked" for="images" class="w-full text-center rounded border border-accent p-2 hover:scale-105 hover:border-b-2 transition-all transform">
                            Select Profile Picture
                        </label>

                        <input type="file" name="images[]" id="images" class="hidden" accept="image/*" onchange="handleFileSelect(event)" multiple />
                    </div>

                </div>

                <!-- DETAILS -->
                <div class="w-full flex flex-col space-y-6 lg:items-start lg:w-auto">

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
                            <input name="email" id="email" type="email" class=" w-full border-2 border-b-accent rounded-md p-1 text-md bg-gray-100 focus:outline-none focus:border-accent hover: hover:bg-primary30 focus:bg-primary30" placeholder="" required value="<?= $email ?>" />
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
                            <label class="text-light" for="phone_number">Contact Number</label>

                            <!-- phone_number -->
                            <input name="phone_number" id="phone_number" type="text" class="w-full border-2 border-b-accent rounded-md p-1 text-md bg-gray-100 focus:outline-none focus:border-accent hover: hover:bg-primary30 focus:bg-primary30" placeholder="" value="<?= $phoneNumber ?>" />
                        </div>
                    </div>


                    <div class="container flex flex-col space-y-4 items-center lg:flex-row lg:space-y-0 lg:space-x-4">


                        <div class="w-full md:w-2/3 lg:container flex flex-col space-y-2 items-start">
                            <label class="text-light" for="birthdate">Birthdate</label>

                            <!-- birthdate -->
                            <input onchange="onBirthdateChange(this)" name="birthdate" id="birthdate" type="date" class="w-full border-2 border-b-accent rounded-md p-1 text-md bg-gray-100 focus:outline-none focus:border-accent hover: hover:bg-primary30 focus:bg-primary30" placeholder="" value="<?= $birthdate ?>" />
                        </div>



                        <div class="h-full w-full md:w-2/3 lg:container flex flex-col space-y-2 items-start">
                            <label class="text-light" for="age">Age</label>

                            <!-- age -->
                            <input disabled name="age" id="age" type="text" class="w-full border-2 border-b-accent rounded-md p-1 text-md bg-gray-100 focus:outline-none focus:border-accent hover: hover:bg-primary30 focus:bg-primary30" placeholder="" value="<?= $age ?>" />
                        </div>
                    </div>
                    <div class="container flex space-x-8 items-center justify-center">
                        <!-- Btn Submit -->
                        <a name="action" type="Submit" class="<?= $isViewProfile ? '' : 'hidden' ?> w-full md:w-2/3 lg:w-1/2 border-2 border-accent text-center rounded-md p-2 px-4 text-lg bg-red-400 hover:bg-secondary50 focus:bg-primary30" href="./profile.php?viewprofile=1&res=confirmdeleteprofile">Delete</a>


                        <button name="action" type="Submit" class="w-full md:w-2/3 lg:w-1/2 border-2 border-accent text-center rounded-md p-2 px-4 text-lg bg-green-400  hover:bg-secondary50 " placeholder="SUBMIT" value="<?= $isViewProfile ? 'updateprofile' : 'saveprofile' ?>">Save</button>
                    </div>
                </div>

            </form>

        </div>
    </main>

    <?php
    include_once '../components/modals.php';

    switch ($_GET['res']) {
        case 'accountupdatesuccess':
            echo createModal(
                title: "Account update successfully.",
                visible: true,
                message: "Your profile information has been successfully update.",
            );
            break;
        case 'usernameexists':
            echo createModal(
                title: "Username Exists.",
                message: "The username you entered is already taken. Please try another one.",
                visible: true
            );
            break;
        case 'accountupdateerror':
            echo createModal(
                title: "Error on updating account.",
                visible: true,
                message: "Cannot update your account right now.",
            );
            break;
        case 'confirmdeleteprofile':
            echo createModal(
                title: "Confirm Delete.",
                visible: true,
                message: "Are you sure you want to delete your account?",
                btnConfirm: "Yes. We will miss you.",
                btnClose: "No.",
                btnFunc: "window.location.replace('./register.php?action=deleteprofile')"
            );
            break;
        case 'accountdeleteerror':
            echo createModal(
                title: "Error on deleting account.",
                visible: true,
                message: "Cannot delete your account right now.",
            );
            break;

        default:
            break;
    }




    ?>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="../js/index.js"></script>
</body>

</html>