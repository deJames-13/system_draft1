<?php
error_reporting(E_ERROR | E_PARSE);

session_start();

if (!empty($_GET['fromLogout']) && $_GET['fromLogout'] == '1') {
    session_destroy();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Log In</title>

    <?php require_once '../scripts/links.php'; ?>
</head>

<body class="relative text-accent">
    <div class="hidden login-bg lg:block">
        <img src="../img/log-in-bg.png" alt="" />
    </div>

    <?php include_once '../components/header.php'; ?>

    <main>
        <div class="border mt-12 flex items-center justify-center p-6 h-48 bg-cover bg-opacity-50 bg-center bg-no-repeat drop-shadow-lg lg:hidden" style="background-image: url(../img/sign-in-bg.png)">
            <h1 class="text-center self-center text-5xl text-white font-semibold drop-shadow-lg hover:text-primary hover:cursor-pointer hover:text-6xl hover:transition-all">
                LOG IN
            </h1>
        </div>

        <div class="flex flex-col items-center mx-auto py-12 px-4 w-auto lg:flex-row-reverse lg:justify-around lg:px-10">
            <form action="./verify.php" method="post" class="container flex flex-col space-y-6 items-center lg:w-1/2 lg:items-end">
                <h1 class="hidden text-5xl text-accent font-semibold hover:text-secondary lg:text-6xl lg:block">
                    LOG IN
                    <i class="fas fa-arrow-right-to-bracket"></i>
                </h1>

                <input id="username" name="username" type="text" class="w-2/3 border-2 border-b-accent rounded-md p-2 px-4 text-lg bg-gray-100 focus:outline-none  focus:bg-transparent focus:border-accent" placeholder="Username" />

                <div class="w-2/3 flex space-x-4 items-center border-2 border-b-accent rounded-md p-2 px-4 text-lg bg-gray-100">

                    <input id="password" name="password" type="password" class="w-full bg-transparent bg-opacity-0   focus:outline-none focus:bg-transparent focus:border-accent" placeholder="Password" />

                    <span id="showIcon" onclick="showPassword(this)"><i class="fas fa-eye hover:text-secondary"></i></span>
                    <span id="hideIcon" onclick="showPassword(this)" class="hidden hover:text-secondary"><i class="fas fa-eye-slash"></i></span>
                </div>

                <input type="submit" class="w-2/3 mt-2 border border-accent rounded-md p-2 px-4 text-lg bg-primary30 focus:outline-none focus:border-accent hover:border-2 hover: hover:bg-primary50 focus:bg-primary30" value="Log in" name="action" />


                <div class="container flex flex-col space-y-6 items-center w-2/3 p-4 lg:hidden">
                    <p>Doesn't have an account?</p>
                    <h3>
                        <a href="./signup.php" class="text-primary font-bold text-xl hover:text-secondary hover:text-2xl hover:transition-all">
                            SIGN UP
                        </a>
                        here.
                    </h3>
                </div>
            </form>

            <div class="hidden lg:mt-16 lg:flex lg:flex-col lg:space-y-4 lg:items-center lg:w-1/3 lg:h-64">
                <p>Doesn't have an account?</p>
                <a href="./signup.php" class="text-center text-7xl text-white font-semibold drop-shadow-2xl hover:text-primary hover:cursor-pointer hover:text-8xl hover:transition-all">
                    SIGN UP
                </a>
            </div>
        </div>
    </main>

    <?php include_once '../components/modals.php';
    switch ($_GET['res']) {
        case 'wronguser':
            echo createModal(
                title: "Unknown username.",
                message: "The username is not found. Please try again or sign up with the username.",
                visible: true,
                btnConfirm: "Sign up",
                btnFunc: "()=>{window.location.replace('./signup.php')}"
            );
            break;
        case 'wrongpass':
            echo createModal(
                title: "Incorrect password.",
                message: "The password you entered does not match. Please try again.",
                visible: true,
            );
            break;
        case 'usernotfound':
            echo createModal(
                title: "Sign in first",
                message: "Please sign up or log in to an existing account to have transactions on our shop.",
                visible: true,
            );
            break;
        case 'deleteaccountsuccess':
            echo createModal(
                title: "Account deleted.",
                message: "We're sorry to see you go.",
                visible: true,
            );
            break;
        default:
            break;
    }
    ?>
    <script src="../js/index.js"></script>
</body>

</html>