<?php
error_reporting(E_ERROR | E_PARSE);
$username = null;
$email = null;
if (isset($_SESSION['newUser'])) {
    $username = $_SESSION['newUser']['username'];
    $email = $_SESSION['newUser']['email'];
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
    <div class="hidden sign-up-bg lg:block">
        <img src="../img/tilted_signin_bg.png" alt="" />
    </div>

    <?php include_once '../components/header.php'; ?>

    <main>
        <div class="border mt-12 flex items-center justify-center p-6 h-48 bg-cover bg-opacity-50 bg-center bg-no-repeat drop-shadow-lg lg:hidden" style="background-image: url(../img/sign-in-bg.png)">
            <h1 class="text-center self-center text-5xl text-white font-semibold drop-shadow-lg hover:text-primary hover:cursor-pointer hover:text-6xl hover:transition-all">
                Sign In
            </h1>
        </div>

        <div class="flex flex-col-reverse items-center mx-auto py-12 px-4 w-auto lg:flex-row lg:justify-around lg:px-10">
            <form method="post" action="./register.php" class="container flex flex-col space-y-6 items-center lg:w-1/2 lg:items-start">
                <h1 class="hidden text-5xl text-accent font-semibold hover:text-secondary lg:text-6xl lg:block">
                    <i class="fas fa-pen-to-square"></i>
                    Sign in
                </h1>
                <input name="email" id="email" type="email" class="w-2/3 border-2 border-b-accent rounded-md p-2 px-4 text-lg bg-gray-100 focus:outline-none focus:border-accent hover: hover:bg-primary30 focus:bg-primary30" placeholder="Email" required value="<?= $email ?? '' ?>" />
                <input name="username" id="username" type="text" class="w-2/3 border-2 border-b-accent rounded-md p-2 px-4 text-lg bg-gray-100 focus:outline-none focus:border-accent hover: hover:bg-primary30 focus:bg-primary30" placeholder="Username" required value="<?= $username ?? '' ?>" />

                <div class="w-2/3 flex space-x-4 items-center border-2 border-b-accent rounded-md p-2 px-4 text-lg bg-gray-100">

                    <input id="password" name="password" type="password" class="w-full bg-transparent bg-opacity-0   focus:outline-none focus:bg-transparent focus:border-accent" placeholder="Password (8 - 15 characters)" />

                    <span id="showIcon" onclick="showPassword(this)"><i class="fas fa-eye hover:text-secondary"></i></span>
                    <span id="hideIcon" onclick="showPassword(this)" class="hidden hover:text-secondary"><i class="fas fa-eye-slash"></i></span>
                </div>

                <input name="confirmPass" id="confirmPass" type="password" class="w-2/3 border-2 border-b-accent rounded-md p-2 px-4 text-lg bg-gray-100 focus:outline-none focus:border-accent hover: hover:bg-primary30 focus:bg-primary30" placeholder="Confirm Password" required />

                <button name="action" type="submit" class="w-2/3 mt-2 border border-accent rounded-md p-2 px-4 text-lg bg-primary30 focus:outline-none focus:border-accent hover:border-2 hover: hover:bg-primary50 focus:bg-primary30" value="signup"> Submit </button>

                <!-- optional -->
                <div class="container flex flex-col space-y-6 items-center w-2/3 p-4 lg:hidden">
                    <p>Already Have an account?</p>
                    <h3>
                        <a href="./login.php" class="text-primary font-bold text-xl hover:text-secondary hover:text-2xl hover:transition-all">
                            LOG IN
                        </a>
                    </h3>
                </div>
            </form>

            <div class="hidden lg:mt-12 lg:flex lg:flex-col lg:space-y-4 lg:items-center lg:w-1/3 lg:h-64">
                <p>Already Have an account?</p>
                <a href="./login.php" class="text-center text-7xl text-white font-semibold drop-shadow-2xl hover:text-primary hover:cursor-pointer hover:text-8xl hover:transition-all">
                    LOG IN
                </a>
            </div>
        </div>
    </main>
    <?php
    include_once '../components/modals.php';

    switch ($_GET['res']) {
        case 'incorrectpassword':
            echo createModal(
                title: "Incorrect Password.",
                visible: true,
                message: "The password you entered does not match.",
            );
            break;
        case 'passwordtooshort':
            echo createModal(
                title: "Password too short.",
                visible: true,
                message: "The password you entered is invalid. Please enter password with 8 - 15 chracters.",
            );
            break;
        case 'passwordtoolong':
            echo createModal(
                title: "Password too long.",
                visible: true,
                message: "The password you entered is invalid. Please enter password with 8 - 15 chracters.",
            );
            break;
        case 'accountcreateerror':
            echo createModal(
                title: "Account Error.",
                visible: true,
                message: "There is an error while creating an account.",
            );
            break;
        case 'accountcreateerror':
            echo createModal(
                title: "Account Error.",
                visible: true,
                message: "There is an error while creating an account.",
            );
            break;
        case 'accountexists':
            echo createModal(
                title: "Account Already Exists.",
                visible: true,
                message: "The account you are trying to create already exists. Please try again with another username or email.",
            );
            break;

        default:
            # code...
            break;
    }




    ?>
    <script src="../js/index.js"></script>
</body>

</html>