<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign In</title>

    <?php require_once '../scripts/links.php'; ?>
</head>

<body class="relative">
    <div class="hidden sign-up-bg lg:block">
        <img src="../img/tilted_signin_bg.png" alt="" />
    </div>

    <?php include '../components/header.php'; ?>

    <main>
        <div class="border mt-12 flex items-center justify-center p-6 h-48 bg-cover bg-opacity-50 bg-center bg-no-repeat drop-shadow-lg lg:hidden" style="background-image: url(../img/sign-in-bg.png)">
            <h1 class="text-center self-center text-5xl text-white font-semibold drop-shadow-lg hover:text-primary hover:cursor-pointer hover:text-6xl hover:transition-all">
                Sign In
            </h1>
        </div>

        <div class="flex flex-col-reverse items-center mx-auto py-12 px-4 w-auto lg:flex-row lg:justify-around lg:px-10">
            <form class="container flex flex-col space-y-6 items-center lg:w-1/2 lg:items-start">
                <h1 class="hidden text-5xl text-accent font-semibold hover:text-secondary lg:text-6xl lg:block">
                    <i class="fas fa-pen-to-square"></i>
                    Sign in
                </h1>
                <input type="email" class="w-2/3 border-2 border-b-accent rounded-md p-2 px-4 text-lg bg-gray-100 focus:outline-none focus:border-accent hover: hover:bg-primary30 focus:bg-primary30" placeholder="Email" />
                <input type="text" class="w-2/3 border-2 border-b-accent rounded-md p-2 px-4 text-lg bg-gray-100 focus:outline-none focus:border-accent hover: hover:bg-primary30 focus:bg-primary30" placeholder="Username" />
                <input type="password" class="w-2/3 border-2 border-b-accent rounded-md p-2 px-4 text-lg bg-gray-100 focus:outline-none focus:border-accent hover: hover:bg-primary30 focus:bg-primary30" placeholder="Password" />
                <input type="password" class="w-2/3 border-2 border-b-accent rounded-md p-2 px-4 text-lg bg-gray-100 focus:outline-none focus:border-accent hover: hover:bg-primary30 focus:bg-primary30" placeholder="Confirm Password" />
                <input type="submit" class="w-2/3 mt-2 border border-accent rounded-md p-2 px-4 text-lg bg-primary30 focus:outline-none focus:border-accent hover:border-2 hover: hover:bg-primary50 focus:bg-primary30" value="Submit" />

                <!-- optional -->
                <div class="container flex flex-col space-y-6 items-center w-2/3 p-4 lg:hidden">
                    <p>Already Have an account?</p>
                    <h3>
                        <a href="./login.php" class="text-primary font-bold text-xl hover:text-secondary hover:text-2xl hover:transition-all">
                            Log In
                        </a>
                    </h3>
                </div>
            </form>

            <div class="hidden lg:mt-12 lg:flex lg:flex-col lg:space-y-4 lg:items-center lg:w-1/3 lg:h-64">
                <p>Already Have an account?</p>
                <a href="./login.php" class="text-center text-7xl text-white font-semibold drop-shadow-2xl hover:text-primary hover:cursor-pointer hover:text-8xl hover:transition-all">
                    Log In
                </a>
            </div>
        </div>
    </main>
</body>

</html>