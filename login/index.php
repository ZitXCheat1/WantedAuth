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
    http_response_code(500);
    \dashboard\primary\error($exception->getMessage());
});

$istwofa = $_SESSION["temp_istwofamode"] ? true : false;

?>

<!DOCTYPE html>
<html lang="en" class="bg-[#09090d] text-white overflow-x-hidden">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="title" content="WantedAuth - Private Client Auth">

    <meta content="Secure your software against piracy, an issue causing $422 million in losses annually - Fair pricing & Features not seen in competitors" name="description" />
    <meta content="WantedAuth" name="author" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="WantedAuth, Cloud Authentication, Key Authentication,Authentication, API authentication,Security, Encryption authentication, Authenticated encryption, Cybersecurity, Developer, SaaS, Software Licensing, Licensing" />
    <meta property="og:description" content="Secure your software against piracy, an issue causing $422 million in losses annually - Fair pricing & Features not seen in competitors" />
    <meta property="og:image" content="/wantedauth-logo.png" />
    <meta property="og:site_name" content="WantedAuth | Secure your software from piracy." />
    <link rel="shortcut icon" type="image/png" href="/wantedauth-logo.png">

    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="WantedAuth - Private Client Auth">
    <meta itemprop="description" content="Secure your software against piracy, an issue causing $422 million in losses annually - Fair pricing & Features not seen in competitors">
    <meta itemprop="image" content="/wantedauth-logo.png">
    <meta name="twitter:card" content="product">
    <meta name="twitter:site" content="@keyauth">
    <meta name="twitter:title" content="WantedAuth - Private Client Auth">

    <meta name="twitter:description" content="Secure your software against piracy, an issue causing $422 million in losses annually - Fair pricing & Features not seen in competitors">
    <meta name="twitter:creator" content="@keyauth">
    <meta name="twitter:image" content="/wantedauth-logo.png">

    <!-- Open Graph data -->
    <meta property="og:title" content="WantedAuth - Private Client Auth" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="./" />

    <title>WantedAuth - Login</title>

    <!-- Canonical SEO -->
    <link rel="canonical" href="https://keyauth.cc" />

    <link rel="stylesheet" href="https://cdn.keyauth.cc/v3/scripts/animate.min.css" />
    <link rel="stylesheet" href="https://cdn.keyauth.cc/v3/dist/output.css">
    <style>
        html, body {
            background:
                radial-gradient(circle at top left, rgba(255, 122, 122, 0.14), transparent 30%),
                radial-gradient(circle at top right, rgba(170, 15, 15, 0.16), transparent 34%),
                linear-gradient(180deg, #120608 0%, #17080a 54%, #220c11 100%);
        }

        .bg-blue-600,
        .bg-blue-700 {
            background-color: #b71717 !important;
        }

        .hover\:bg-blue-800:hover,
        .hover\:bg-blue-700:hover {
            background-color: #8c1212 !important;
        }

        .text-blue-500,
        .text-blue-600 {
            color: #ff8f8f !important;
        }

        .from-sky-400 {
            --tw-gradient-from: #ff8f8f var(--tw-gradient-from-position) !important;
            --tw-gradient-to: rgb(255 143 143 / 0) var(--tw-gradient-to-position) !important;
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to) !important;
        }

        .to-blue-600 {
            --tw-gradient-to: #c51515 var(--tw-gradient-to-position) !important;
        }

        .nav-logo {
            display: block;
            width: auto;
            height: 42px !important;
            max-width: 180px;
            object-fit: contain;
        }
    </style>

</head>

<body>
    <header>
        <nav class="border-gray-200 px-4 lg:px-6 py-2.5 mb-14">
            <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl">
                <a href="../" class="flex items-center">
                    <img src="/wantedauth-logo.png" class="mr-3 nav-logo" alt="WantedAuth Logo" />
                </a>
                <div class="flex items-center lg:order-2">
                    <a href="../login" class="text-white focus:ring-0 font-medium rounded-lg text-sm px-4 py-2 lg:px-5 lg:py-2.5 mr-2 hover:opacity-60 transition duration-200 focus:outline-none focus:ring-gray-800">
                        Client Area
                    </a>
                    <a href="../register" class="text-white focus:ring-0 font-medium rounded-lg text-sm px-4 py-2 lg:px-5 lg:py-2.5 mr-2 bg-blue-600 hover:opacity-80 focus:outline-none focus:ring-blue-800 transition duration-200">
                        Onboard Now
                    </a>
                    <button data-collapse-toggle="mmenu" type="button" class="inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200  " aria-controls="mmenu" aria-expanded="false">
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
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <section>
        <div class="relative z-10 flex flex-wrap md:-m-8 ml-8 md:ml-24">
            <div class="w-full md:w-1/2 md:p-8">
                <div class="md:max-w-lg md:mx-auto md:pt-36">
                    <h2 class="mb-7 md:mb-12 text-3xl md:text-6xl font-bold font-heading tracking-px-n leading-tight text-center">
                        Welcome back to <span class="text-transparent bg-clip-text bg-gradient-to-r to-blue-600 from-sky-400 inline-block">WantedAuth</span>
                        👋
                    </h2>

                    <h3 class="mb-9 text-sm md:text-xl font-bold font-heading leading-normal">
                        The best authentication platform for your software.
                    </h3>
                </div>
            </div>
            <div class="w-full md:w-1/2 md:p-8 -ml-4 md:-ml-12">
                <div class="p-2 md:p-4 py-16 flex flex-col justify-center h-full">
                    <form class="md:max-w-md md:ml-32 space-y-4 md:space-y-6" method="post" data-postform="1">
                        <?php

                        if ($istwofa) {
                        ?>
                            <script>
                                let username = "<?= $_SESSION["temp_username"]; ?>"
                                let password = "<?= $_SESSION["temp_password"]; ?>"
                            </script>

                            <input type="hidden" id="username" name="username" value="${username}">
                            <input type="hidden" id="password" name="password" value="${password}">

                            <script>
                                document.getElementById("username").value = username;
                                document.getElementById("password").value = password;
                            </script>

                            <div class="relative mb-4" data-twofactor="1">
                                <input type="text" id="keyauthtwofactor" name="keyauthtwofactor" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-white bg-transparent rounded-lg border-1 border-border-gray-300 appearance-none focus:ring-0  peer" placeholder=" " autocomplete="on">
                                <label for="keyauthtwofactor" class="absolute text-sm text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-[#09090d] px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">2FA
                                    <span class="text-xs">(Two Factor Authentication)</span></label>
                            </div>

                            <button name="login" data-loginbutton="1" class="text-white border-2 hover:bg-white hover:text-black focus:ring-0 focus:outline-none transition duration-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center items-center mb-3 w-full mt-10">
                                <span class="inline-flex">
                                    Submit 2FA Code
                                    <svg class="w-3.5 h-3.5 ml-2 mt-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"></path>
                                    </svg></span>
                            </button>

                        <?php
                        } else {
                        ?>
                            <div class="relative mb-4" data-username="1">
                                <input type="text" id="username" name="username" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-white bg-transparent rounded-lg border-1 border-border-gray-300 appearance-none focus:ring-0  peer" placeholder=" " autocomplete="on" required="">
                                <label for="username" class="absolute text-sm text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-[#09090d] px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Username</label>
                            </div>

                            <div class="relative mb-4" data-password="1">
                                <input type="password" id="password" name="password" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-white bg-transparent rounded-lg border-1 border-border-gray-300 appearance-none focus:ring-0  peer" placeholder=" " autocomplete="on" required="">
                                <label for="password" class="absolute text-sm text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-[#09090d] px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Password</label>
                            </div>

                            <div class="relative mb-4" data-twofactor="1">
                                <input type="text" id="keyauthtwofactor" name="keyauthtwofactor" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-white bg-transparent rounded-lg border-1 border-border-gray-300 appearance-none focus:ring-0  peer" placeholder=" " autocomplete="on">
                                <label for="keyauthtwofactor" class="absolute text-sm text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-[#09090d] px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">2FA
                                    <span class="text-xs">(Two Factor Authentication)</span></label>
                            </div>

                            <button name="login" data-loginbutton="1" class="text-white border-2 hover:bg-white hover:text-black focus:ring-0 focus:outline-none transition duration-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center items-center mb-3 w-full mt-10">
                                <span class="inline-flex">
                                    Login Now
                                    <svg class="w-3.5 h-3.5 ml-2 mt-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"></path>
                                    </svg></span>
                            </button>

                            <div class="text-sm font-medium text-white mb-4">
                                Forgot your password? <a href="../forgot/" class="hover:underline text-blue-500">Reset
                                    It</a> Now!
                            </div>

                            <div class="text-sm font-medium text-white">
                                Need an Account? <a href="../register/" class="hover:underline text-blue-500">Register</a>
                            </div>
                        <?php
                        }

                        ?>
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


    <?php
    if (isset($_POST['login'])) {
        $username = misc\etc\sanitize($_POST['username']);
        $password = misc\etc\sanitize($_POST['password']);

        $query = misc\mysql\query("SELECT * FROM `accounts` WHERE `username` = ?", [$username]);

        if ($query->num_rows < 1) {
            dashboard\primary\error("Account doesn't exist!");
            return;
        }
        while ($row = mysqli_fetch_array($query->result)) {
            $user = $row['username'];
            $pass = $row['password'];
            $id = $row['ownerid'];
            $email = $row['email'];
            $role = $row['role'];
            $app = misc\etc\sanitize($row['app']);
            $banned = $row['banned'];
            $locked = $row['locked'];
            $img = $row['img'];

            $owner = misc\etc\sanitize($row['owner']);
            $twofactor_optional = $row['twofactor'];
            $acclogs = $row['acclogs'];
            $google_Code = $row['googleAuthCode'];

            $regionSaved = $row['region'];
            $asNumSaved = $row['asNum'];
            $emailVerify = $row['emailVerify'];
            $securityKey = $row['securityKey'];
        }

        if (!is_null($banned)) {
            dashboard\primary\error("Banned: Reason: " . misc\etc\sanitize($banned));
            return;
        }

        if (!password_verify($password, $pass)) {
            dashboard\primary\error("Password is invalid!");
            return;
        }
        
        if ($locked) {
            header("location: ./accShare/");
            die();
        }
        
        if (misc\etc\isBreached($password)) {
            dashboard\primary\wh_log($logwebhook, "{$username} attempted to login with leaked password `{$password}`", $webhookun);
            dashboard\primary\error("Password has been leaked in a data breach (not from us)! You must click Forgot Password and change password.");
            return;
        }
        
        $ip = api\shared\primary\getIp();
        
        /*
        * Email verification
        * For paid customers, checks if ISP and region (aka state) match. If not, they must verify it's them via an email.
        * Customers can opt to disable email verification.
        * This code is also used to notify the WantedAuth owner of account sharing, since that's against our ToS.
        */
        if (in_array($role, array("developer", "seller")) && $username != "demoseller" && $username != "demodeveloper" && !empty($awsAccessKey)) {
            $url = "http://ip-api.com/json/{$ip}?fields=16910340"; // returns fields: region,as,proxy,hosting

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $resp = curl_exec($curl);
            $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            
            if($httpcode == 429) {
                dashboard\primary\wh_log($logwebhook, "<@1138519014734319706> IP checking is rate limited", $webhookun);
                dashboard\primary\error("Login location is rate-limited! Please try again in a minute or so.");
                return;
            }
            else {
                $json = json_decode($resp, true);
                $region = $json["region"];
                $asNum = explode(" ", $json["as"])[0];
                if (!is_null($asNumSaved)) {
                    if ($asNum != $asNumSaved || $region != $regionSaved) {
                        // if user not using VPN and IP location changed, notify WantedAuth owner of account sharing
                        if(!$json->proxy && !$json->hosting && $region != $regionSaved) {
                            dashboard\primary\wh_log($logwebhook, "user `{$username}` detected account sharing **IP Address:** `{$ip}` **Old AS:** {$asNumSaved} **New AS:** {$asNum} **Old Region:** {$regionSaved} **New Region:** {$region}", $webhookun);
                            if(!$emailVerify) {
                                misc\mysql\query("UPDATE `accounts` SET `region` = ?,`asNum` = ?,`lastip` = ? WHERE `username` = ?",[$region, $asNum, $ip, $username]);
                            }
                        }
                        
                        if($emailVerify) { // only require email verification if enabled.
                            if ($twofactor_optional) {
                                // 2FA verification on new login location
                                $twofactor = misc\etc\sanitize($_POST['keyauthtwofactor']);
                                if (empty($twofactor)) {
                                    dashboard\primary\error("Please enter 2FA code!");
                                    return;
                                }
        
                                require_once '../auth/GoogleAuthenticator.php';
                                $gauth = new GoogleAuthenticator();
                                $checkResult = $gauth->verifyCode($google_Code, $twofactor, 2);
        
                                if (!$checkResult) {
                                    dashboard\primary\error("Invalid 2FA code! Make sure your device time settings are synced.");
                                    return;
                                }
                                
                                misc\mysql\query("UPDATE `accounts` SET `region` = ?,`asNum` = ?,`lastip` = ? WHERE `username` = ?",[$region, $asNum, $ip, $username]);
                            } else {
                                // email verification on new login location
                                header("location: ./emailVerify/");
                                die();
                            }
                        }
                    }
                }
                else {
                    misc\mysql\query("UPDATE `accounts` SET `region` = ?,`asNum` = ?,`lastip` = ? WHERE `username` = ?",[$region, $asNum, $ip, $username]);
                }
            }
        }
        
        if((!$emailVerify || $role == "tester") && $twofactor_optional) {
            require_once '../auth/GoogleAuthenticator.php';
            $gauth = new GoogleAuthenticator();
            $twofactor = misc\etc\sanitize($_POST['keyauthtwofactor']);
            $checkResult = $gauth->verifyCode($google_Code, $twofactor, 2);

            if (!$checkResult) {
                dashboard\primary\error("Invalid 2FA code! Make sure your device time settings are synced.");
                return;
            }
        }

        $_SESSION['username'] = $username;
        $_SESSION['ownerid'] = $id;
        $_SESSION['role'] = $role;
        $_SESSION['logindate'] = time();
        $_SESSION['img'] = $img;
        
        if($securityKey) {
            // set a temporary session variable to be used until the user completes WebAuthn
            unset($_SESSION['username']);
            $_SESSION['pendingUsername'] = $username;
            header("location: ./securityKey.html");
            die();
        }

        if ($role == "Reseller" || $role == "Manager") {
            ($query = misc\mysql\query("SELECT `secret`, `ownerid` FROM `apps` WHERE `name` = ? AND `owner` = ?",[$app, $owner]));
            if ($query->num_rows < 1) {
                dashboard\primary\error("Application you're assigned to no longer exists!");
                return;
            }
            while ($row = mysqli_fetch_array($query->result)) {
                $secret = $row["secret"];
                $ownerid = $row["ownerid"];
            }
            $_SESSION['app'] = $secret;
            $_SESSION['name'] = $app;
            $_SESSION['ownerid'] = $ownerid;
        }
        
        if ($acclogs) // check if account logs enabled
        {
            $ua = misc\etc\sanitize($_SERVER['HTTP_USER_AGENT']);
            misc\mysql\query("INSERT INTO `acclogs`(`username`, `date`, `ip`, `useragent`) VALUES (?, ?, ?, ?);",[$username, time(), $ip, $ua]); // insert ip log
            $ts = time() - 604800;
            misc\mysql\query("DELETE FROM `acclogs` WHERE `username` = ? AND `date` < ?",[$username, $ts]); // delete any account logs more than a week old
        }
        
        if(strtolower($username) != "itsnetworking") {
            dashboard\primary\wh_log($logwebhook, "{$username} has logged into WantedAuth with IP `{$ip}`", $webhookun);
        }

        if ($role == "Reseller") {
            header("location: ../app/?page=reseller-licenses");
        } else if (!is_null($_SESSION['oldUrl'])) {
            header("location: " . $_SESSION['oldUrl']);
        } else {
            header("location: ../app/");
        }
    }?>
</body>

</html>
