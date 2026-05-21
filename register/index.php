<?php
require '../includes/misc/autoload.phtml';
require '../includes/dashboard/autoload.phtml';
require '../includes/api/shared/autoload.phtml';
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['username'])) {
    header("Location: ../app/");
    exit();
}
set_exception_handler(function ($exception) {
    error_log("\n--------------------------------------------------------------\n");
    error_log($exception);
    error_log("\nRequest data:");
    error_log(print_r($_POST, true));
    error_log("\n--------------------------------------------------------------");

    if ($exception instanceof \mysqli_sql_exception) {
        http_response_code(200);
        \dashboard\primary\error("Database connection failed. Start MySQL or MariaDB, create the `main` database, import `db_structure.sql`, and check includes/credentials.php.");
        return;
    }

    http_response_code(500);
    \dashboard\primary\error($exception->getMessage());
});
?>

<!DOCTYPE html>
<html lang="en" class="bg-[#09090d] text-white overflow-x-hidden">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="title" content="WantedAuth - Open Source Auth">

    <meta content="Secure your software against piracy, an issue causing $422 million in losses annually - Fair pricing & Features not seen in competitors" name="description" />
    <meta content="WantedAuth" name="author" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="WantedAuth, Cloud Authentication, Key Authentication,Authentication, API authentication,Security, Encryption authentication, Authenticated encryption, Cybersecurity, Developer, SaaS, Software Licensing, Licensing" />
    <meta property="og:description" content="Secure your software against piracy, an issue causing $422 million in losses annually - Fair pricing & Features not seen in competitors" />
    <meta property="og:image" content="/wantedauth-logo.svg" />
    <meta property="og:site_name" content="WantedAuth | Secure your software from piracy." />
    <link rel="shortcut icon" type="image/jpg" href="/wantedauth-logo.svg">

    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="WantedAuth - Open Source Auth">
    <meta itemprop="description" content="Secure your software against piracy, an issue causing $422 million in losses annually - Fair pricing & Features not seen in competitors">
    <meta itemprop="image" content="/wantedauth-logo.svg">
    <meta name="twitter:card" content="product">
    <meta name="twitter:site" content="@keyauth">
    <meta name="twitter:title" content="WantedAuth - Open Source Auth">

    <meta name="twitter:description" content="Secure your software against piracy, an issue causing $422 million in losses annually - Fair pricing & Features not seen in competitors">
    <meta name="twitter:creator" content="@keyauth">
    <meta name="twitter:image" content="/wantedauth-logo.svg">

    <!-- Open Graph data -->
    <meta property="og:title" content="WantedAuth - Open Source Auth" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="./" />

    <title>WantedAuth - Register</title>

    <!-- Canonical SEO -->
    <link rel="canonical" href="https://keyauth.cc" />

    <link rel="stylesheet" href="https://cdn.keyauth.cc/v3/scripts/animate.min.css" />
    <link rel="stylesheet" href="https://cdn.keyauth.cc/v3/dist/output.css">

    <script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
    </script>
</head>

<body>
    <header class="">
        <nav class="border-gray-200 px-4 lg:px-6 py-2.5 mb-14">
            <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl">
                <a href="../" class="flex items-center">
                    <img src="/wantedauth-logo.svg" class="mr-3 h-12 mt-2" alt="WantedAuth Logo" />
                </a>
                <div class="flex items-center lg:order-2">
                    <a href="../login" class="text-white focus:ring-0 font-medium rounded-lg text-sm px-4 py-2 lg:px-5 lg:py-2.5 mr-2 hover:opacity-60 transition duration-200 focus:outline-none focus:ring-gray-800">
                        Client Area
                    </a>
                    <a href="../register" class="text-white focus:ring-0 font-medium rounded-lg text-sm px-4 py-2 lg:px-5 lg:py-2.5 mr-2 bg-blue-600 hover:opacity-80 focus:outline-none focus:ring-primary-800 transition duration-200">
                        Onboard Now
                    </a>
                    <button data-collapse-toggle="mmenu" type="button" class="inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200   " aria-controls="mmenu" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <svg class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <div class="hidden justify-between items-center w-full lg:flex lg:w-auto lg:order-1" id="mmenu">
                    <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">
                        <li>
                            <a href="../" class="block py-2 pr-4 pl-3 border-b lg:hover:bg-transparent lg:border-0 lg:p-0 text-gray-400 hover:bg-gray-700 hover:text-white lg:hover:bg-transparent border-gray-700 transition duration-200" aria-current="page">Home</a>
                        </li>
                        <li>
                            <a href="../#features" class="block py-2 pr-4 pl-3 border-b lg:hover:bg-transparent lg:border-0 lg:p-0 text-gray-400 hover:bg-gray-700 hover:text-white lg:hover:bg-transparent border-gray-700 transition duration-200">Features</a>
                        </li>
                        <li>
                            <a href="../#plans" class="block py-2 pr-4 pl-3 border-b lg:hover:bg-transparent lg:border-0 lg:p-0 text-gray-400 hover:bg-gray-700 hover:text-white lg:hover:bg-transparent border-gray-700 transition duration-200">
                                Plans
                            </a>
                        </li>
                        <li>
                            <a href="../#team" class="block py-2 pr-4 pl-3 border-b lg:hover:bg-transparent lg:border-0 lg:p-0 text-gray-400 hover:bg-gray-700 hover:text-white lg:hover:bg-transparent border-gray-700 transition duration-200">
                                Our Team
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <section>
        <div class="relative flex flex-wrap md:-m-8 ml-8 md:ml-24">
            <div class="w-full md:w-1/2 md:p-8">
                <div class="md:max-w-lg md:mx-auto md:pt-36">
                <h2
                    class="mb-7 md:mb-12 text-3xl md:text-6xl font-bold font-heading tracking-px-n leading-tight text-center">
                        Welcome to <span class="text-transparent bg-clip-text bg-gradient-to-r to-blue-600 from-sky-400">WantedAuth</span>!
                    </h2>
                    <h3 class="mb-9 text-sm md:text-xl font-bold font-heading leading-normal">
                        The best authentication platform for your software.
                    </h3>
                </div>
            </div>
            <div class="w-full md:w-1/2 md:p-8 -ml-4 md:-ml-0">
                <div class="p-4 py-16 flex flex-col justify-center h-full md:-ml-32">
                    <form class="md:max-w-lg md:ml-48 space-y-4 md:space-y-6" method="post">
                        <div class="relative mb-4">
                            <input type="text" id="username" name="username" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-white bg-transparent rounded-lg border-1 border-border-gray-300 appearance-none focus:ring-0 peer" placeholder=" " autocomplete="on" required>
                            <label for="username" class="absolute text-sm text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 origin-[0] bg-[#09090d] px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Username</label>
                        </div>
                        <div class="relative mb-4">
                            <input type="email" id="email" name="email" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-white bg-transparent rounded-lg border-1 border-border-gray-300 appearance-none focus:ring-0 peer" placeholder=" " autocomplete="on" required>
                            <label for="email" class="absolute text-sm text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 origin-[0] bg-[#09090d] px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Email</label>
                        </div>

                        <div class="relative mb-4">
                            <input type="password" id="password" name="password" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-white bg-transparent rounded-lg border-1 border-border-gray-300 appearance-none focus:ring-0 peer" placeholder=" " data-popover-target="popover-password" data-popover-placement="bottom" autocomplete="on" required>
                            <label for="password" class="absolute text-sm text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 origin-[0] bg-[#09090d] px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Password</label>
                        </div>

                        <div class="relative mb-4">
                            <input type="password" id="confirmpassword" name="confirmpassword" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-white bg-transparent rounded-lg border-1 border-border-gray-300 appearance-none focus:ring-0 peer" placeholder=" " data-popover-target="popover-password" data-popover-placement="bottom" autocomplete="on" required>
                            <label for="confirmpassword" class="absolute text-sm text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 origin-[0] bg-[#09090d] px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Confirm Password</label>
                        </div>

                        <div data-popover id="popover-password" role="tooltip" class="absolute invisible inline-block text-sm text-white transition-opacity duration-300 bg-[#09090d] border border-[#0f0f17] rounded-lg shadow-sm opacity-0 w-72">
                            <div class="p-3 space-y-2">
                                <h3 class="font-semibold text-white">Must have at least 12 characters</h3>
                                <div class="grid grid-cols-4 gap-2">
                                    <div class="h-1 bg-gray-200" id="pass_strength_one"></div>
                                    <div class="h-1 bg-gray-200" id="pass_strength_two"></div>
                                    <div class="h-1 bg-gray-200" id="pass_strength_three"></div>
                                    <div class="h-1 bg-gray-200" id="pass_strength_four"></div>
                                </div>
                                <p>It’s better to have:</p>
                                <ul>
                                    <li class="flex items-center mb-1">
                                        <svg class="w-3.5 h-3.5 mr-2 text-green-400  " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5" />
                                        </svg>
                                        Upper & lower case letters
                                    </li>
                                    <li class="flex items-center mb-1">
                                        <svg class="w-3.5 h-3.5 mr-2 text-green-400  " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5" />
                                        </svg>
                                        A symbol(s) (#$&)
                                    </li>
                                </ul>
                            </div>
                            <div data-popper-arrow></div>
                        </div>
                        <div>
                            <div class="flex justify-between mb-2">
                                <span class="text-sm font-medium text-white">I Agree To:</span>
                            </div>
                            <ul class="items-center w-full text-sm font-medium border-1 rounded-lg sm:flex bg-[#0f0f17] text-white">
                                <li class="w-full border-b border-gray-700 sm:border-b-0 sm:border-r">
                                    <div class="flex items-center pl-3">
                                        <input name="wontshareCB" id="wontshareCB" type="checkbox" value="" class="w-4 h-4 rounded focus:ring-blue-600 ring-offset-gray-700 focus:ring-offset-gray-700 focus:ring-0 bg-[#09090d] border-[#09090d]">
                                        <label for="wontshareCB" class="w-full py-3 ml-2 text-sm font-medium text-gray-300">Not
                                            share my account</label>
                                    </div>
                                </li>
                                <li class="w-full border-b border-gray-700 sm:border-b-0 sm:border-r ">
                                    <div class="flex items-center pl-3">
                                        <input name="wontdisputeCB" id="wontdisputeCB" type="checkbox" value="" class="w-4 h-4 rounded focus:ring-blue-600 ring-offset-gray-700 focus:ring-offset-gray-700 focus:ring-0 bg-[#09090d] border-[#09090d]">
                                        <label for="wontdisputeCB" class="w-full py-3 ml-2 text-sm font-medium text-gray-300">Not make
                                            any disputes (contact support)</label>
                                    </div>
                                </li>
                                <li class="w-full border-b border-gray-700 sm:border-b-0">
                                    <div class="flex items-center pl-3">
                                        <input name="tosCB" id="tosCB" type="checkbox" value="" class="w-4 h-4 rounded focus:ring-blue-600 ring-offset-gray-700 focus:ring-offset-gray-700 focus:ring-0 bg-[#09090d] border-[#09090d]">
                                        <label for="tosCB" class="w-full py-3 ml-2 text-sm font-medium text-gray-300">Follow
                                            <a href="/terms" target="_blank" class="text-blue-600  hover:underline">Terms and
                                                Conditions</a></label>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <button name="register" class="text-white border-2 hover:bg-white hover:text-black focus:ring-0 focus:outline-none transition duration-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center items-center mb-3 w-full mt-10">
                        <span class="inline-flex">
                                    Register Now
                                    <svg class="w-3.5 h-3.5 ml-2 mt-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"></path>
                                    </svg></span>
                        </button>

                        <div class="text-sm font-medium text-white mb-4">
                            Need a good password manager? Use <a href="https://bitwarden.com/" target="_blank" class="hover:underline text-blue-500">Bitwarden</a> it's free!
                        </div>

                        <div class="text-sm font-medium text-white">
                            Have an Account? <a href="../login" class="hover:underline text-blue-500">Login</a>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-[#09090d]">
    <div class="mx-auto max-w-screen-xl px-4 py-8 text-center text-sm text-gray-500">
        Dashboard ready.
    </div>
</footer>

    <!-- jqeury -->
    <script src="https://cdn.keyauth.cc/v3/scripts/jquery.min.js"></script>

    <!--Flowbite JS-->
    <script src="https://cdn.keyauth.cc/v3/dist/flowbite.js"></script>
    <script>
        $("#password").on("input", function() {
            var value = $(this).val();
            var strength = 0;
            if (value.length > 12) {
                strength += 15;
            }
            if (value.match(/[a-z]+/)) {
                strength += 25;
            }
            if (value.match(/[A-Z]+/)) {
                strength += 25;
            }
            if (value.match(/[0-9]+/)) {
                strength += 25;
            }

            if (value.match(/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/)) {
                strength += 25;
            }

            if (value.length === 0) {
                $("#pass_strength_one, #pass_strength_two, #pass_strength_three, #pass_strength_four").css("background-color", "#ffffff");
            } else if (strength >= 1 && strength <= 25) {
                $("#pass_strength_one").css("background-color", "#ff0000");
                $("#pass_strength_two, #pass_strength_three, #pass_strength_four").css("background-color", "#ffffff");
            } else if (strength >= 26 && strength <= 50) {
                $("#pass_strength_one, #pass_strength_two").css("background-color", "#ff5a00");
                $("#pass_strength_three, #pass_strength_four").css("background-color", "#ffffff");
            } else if (strength >= 51 && strength <= 75) {
                $("#pass_strength_one, #pass_strength_two, #pass_strength_three").css("background-color", "#6acc1a");
                $("#pass_strength_four").css("background-color", "#ffffff");
            } else if (strength >= 76 && strength <= 100) {
                $("#pass_strength_one, #pass_strength_two, #pass_strength_three, #pass_strength_four").css("background-color", "#0c9b18");
            }
        });
    </script>

    <?php
    if (isset($_POST['register'])) {
        $username = misc\etc\sanitize($_POST['username']);
        $password = misc\etc\sanitize($_POST['password']);
        $confirmPass = misc\etc\sanitize($_POST['confirmpassword']);
        $email = misc\etc\sanitize($_POST['email']);
        $pattern = '/\b(http|https)\b|\.(com|win|rar|zip|gov|uk|gg|business|org|cc)\b/i';
        if (empty($username) || empty($password) || empty($email)) {
            dashboard\primary\error("You must specify username, password, and email.");
            return;
        }
        if(preg_match($pattern, $username)){
            dashboard\primary\error("Username can not contain link features.");
            return;
        }
        if (!isset($_POST['wontshareCB'])) {
            dashboard\primary\error("You must agree to not share your account with anyone");
            return;
        }
        if (!isset($_POST['wontdisputeCB'])) {
            dashboard\primary\error("You must agree you won't dispute any charges. (contact support first)");
            return;
        }
        if (!isset($_POST['tosCB'])) {
            dashboard\primary\error("You must agree to the Terms of Service and Privacy Policy");
            return;
        }
        if($password !== $confirmPass){
            dashboard\primary\error("Passwords do not match!");
            return;
        }
        if (strlen($password) >= 33){
            dashboard\primary\error("Password must be less than 33 characters!");
            return;
        }
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number = preg_match('@[0-9]@', $password);
        if (!$uppercase || !$lowercase || !$number || strlen($password) < 12) {
            dashboard\primary\error("Password must have at least one capital letter, one lowercase letter, one number, and be at least 12 characters long.");
            return;
        }
        if (misc\etc\isPhonyEmail($email)) {
            dashboard\primary\error("Please use a real email. You will need email access to reset password, new login location if you have enabled, etc.");
            dashboard\primary\wh_log($logwebhook, "{$username} has failed email validation with `{$email}`", $webhookun);
            return;
        }
        if (misc\etc\isBreached($password)) {
            dashboard\primary\wh_log($logwebhook, "{$username} attempted to register with leaked password `{$password}`", $webhookun);
            dashboard\primary\error("Password has been leaked in a data breach (not from us)! Please use different password.");
            return;
        }
        $query = misc\mysql\query("SELECT 1 FROM `accounts` WHERE `username` = ?", [$username]);
        if ($query->num_rows == 1) {
            dashboard\primary\error("Username already taken!");
            return;
        }
        $query = misc\mysql\query("SELECT `username` FROM `accounts` WHERE `email` = SHA1(?)", [$email]);
        if ($query->num_rows > 0) {
            dashboard\primary\error('Email already used by username: ' . mysqli_fetch_array($query->result)['username'] . '');
            return;
        }
        $pass_encrypted = password_hash($password, PASSWORD_BCRYPT);
        $ownerid = misc\etc\generateRandomString();
        $ip = api\shared\primary\getIp();
        $premiumExpiry = strtotime('+10 years');
        misc\mysql\query("INSERT INTO `accounts` (`username`, `email`, `password`, `ownerid`, `role`, `expires`, `registrationip`) VALUES (?, SHA1(LOWER(?)), ?, ?, 'seller', ?, ?)", [$username, $email, $pass_encrypted, $ownerid, $premiumExpiry, $ip]);
        dashboard\primary\wh_log($logwebhook, "{$username} has registered successfully", $webhookun);
        $htmlContent = "<html>
                                        <body>
                                                <h1>Welcome!</h1>
                                                <p>Your account is ready.</p>
                                                <p>WantedAuth code can be seen here <a href=\"https://github.com/WantedAuth/\">https://github.com/WantedAuth/</a></p>
                                                <p>WantedAuth API documentation can be seen here <a href=\"https://keyauth.readme.io/\">https://keyauth.readme.io/</a></p>
                                                <p>Please leave a review on TrustPilot if you enjoy WantedAuth <a href=\"https://trustpilot.com/review/keyauth.com\">https://trustpilot.com/review/keyauth.com</a></p>
                                                <p style=\"margin-top: 20px;\">Thanks,<br><b>WantedAuth.</b></p>
                                        </body>
                                        </html>";
        misc\email\send($username, $email, $htmlContent, "Welcome to WantedAuth");
        $_SESSION['logindate'] = time();
        $_SESSION['username'] = $username;
        $_SESSION['ownerid'] = $ownerid;
        $_SESSION['role'] = 'seller';
        $_SESSION['img'] = '/wantedauth-logo.svg';
        header("location: ../app/");
    }
    ?>
</body>

</html>
