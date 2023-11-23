<?php

session_start();


if (isset($_SESSION['adminId'])) {
    header('Location: ../');
    exit();
}

if (!empty($_GET['fromLogout']) && $_GET['fromLogout'] == '1') {
    session_destroy();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>

    <?php require_once '../../scripts/links.php' ?>


</head>

<body>
    <main>
        <div class="container h-screen flex items-center justify-center mx-auto">
            <div class="container bg-primary10 border border-accent rounded max-w-sm h-[50%] min-h-2/3 overflow-auto">
                <div class="container py-4 flex items-center justify-center border-b border-accent50">
                    <h1 class="font-bold text-xl text-accent md:text-2xl">
                        Admin Dashboard
                    </h1>
                </div>
                <div class="p-4 flex justify-center items-center">
                    <form action="./login.php" method="post" class="flex items-center flex-col space-y-4">

                        <div>
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" class="w-full border border-accent rounded p-1">
                        </div>
                        <div>
                            <label for="password">Password</label>
                            <input type="password" name="password" id="username" class="w-full border border-accent rounded p-1">
                        </div>

                        <div>
                            <button type="submit" name="action" value="login" id="username" class="w-full border font-semibold border-accent rounded p-1 px-4 transition-all hover:scale-110 hover:border-b-2 hover:bg-primary50"> Log in</button>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </main>
    <?php include_once '../../components/modals.php';

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
                message: "Please sign up or log in to an existing account login as admin.",
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

    <script src="../../js/index.js"></script>

</body>

</html>