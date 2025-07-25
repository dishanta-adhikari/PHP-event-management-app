<?php

require_once __DIR__ . '/_init.php';

use App\Controllers\UserController;

$userController = new UserController($con);

$changePassMessage = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
    $changePassMessage = $userController->updatePassword($_POST);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?php echo $appUrl; ?>/public/assets/images/cropped-GCU-Logo-circle.png">
    <title>Admin</title>
    <link rel="stylesheet" href="<?php echo $appUrl; ?>/public/assets/CSS/dash.css">
    <link rel="stylesheet" href="<?php echo $appUrl; ?>/public/assets/CSS/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        #liveClock {
            color: dark;

        }

        ul {
            background-color: black;
            width: 20rem;
            height: 100%;
            position: fixed;
            padding-top: 5%;
            padding-right: 3%;
            text-align: center;
        }

        h1 {
            padding-left: 2rem;
        }

        #liveClock {
            padding-left: 2rem;
        }

        @media (max-width: 915px) {
            h1 {
                padding: 0 0 0 10rem;
            }

            #liveClock {
                padding: 0 0 0 10rem;
            }

        }


        @media (max-width: 550px) {
            ul {
                background-color: black;
                width: 100%;
                height: 100%;
                position: fixed;
                padding-top: 5%;
                padding-right: 3%;
                text-align: center;
            }

        }

        @media (max-width:1300px) {
            .mx-auto {
                width: 33%;
            }
        }


        @media (max-width: 768px) {
            .changepass {
                width: 80%;
                padding: 20px;
                position: absolute;
                right: -50vh;
                left: -50vh;
            }

            /* Adjust input width and margin */
            .changepass input[type="email"],
            .changepass input[type="password"] {
                width: 100%;
                margin-bottom: 15px;
            }
        }
    </style>


</head>

<body>
    <header>
        <a href="#">
            <svg height="32" id="icon" viewBox="0 0 32 32" width="32" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <style>
                        .cls-1 {
                            fill: none;
                        }
                    </style>
                </defs>
                <path class="cls-1"
                    d="M8.0071,24.93A4.9958,4.9958,0,0,1,13,20h6a4.9959,4.9959,0,0,1,4.9929,4.93,11.94,11.94,0,0,1-15.9858,0ZM20.5,12.5A4.5,4.5,0,1,1,16,8,4.5,4.5,0,0,1,20.5,12.5Z"
                    data-name="&lt;inner-path&gt;" id="_inner-path_" />
                <path
                    d="M26.7489,24.93A13.9893,13.9893,0,1,0,2,16a13.899,13.899,0,0,0,3.2511,8.93l-.02.0166c.07.0845.15.1567.2222.2392.09.1036.1864.2.28.3008.28.3033.5674.5952.87.87.0915.0831.1864.1612.28.2417.32.2759.6484.5372.99.7813.0441.0312.0832.0693.1276.1006v-.0127a13.9011,13.9011,0,0,0,16,0V27.48c.0444-.0313.0835-.0694.1276-.1006.3412-.2441.67-.5054.99-.7813.0936-.08.1885-.1586.28-.2417.3025-.2749.59-.5668.87-.87.0933-.1006.1894-.1972.28-.3008.0719-.0825.1522-.1547.2222-.2392ZM16,8a4.5,4.5,0,1,1-4.5,4.5A4.5,4.5,0,0,1,16,8ZM8.0071,24.93A4.9957,4.9957,0,0,1,13,20h6a4.9958,4.9958,0,0,1,4.9929,4.93,11.94,11.94,0,0,1-15.9858,0Z" />
                <rect class="cls-1" data-name="&lt;Transparent Rectangle&gt;" height="32" id="_Transparent_Rectangle_"
                    width="32" />
            </svg>
            &nbsp; ADMIN</a>
        <div class="logout">
            <a href="<?php echo $appUrl; ?>/src/Views/auth/logout" class="button">logout</a>
            <!-- onclick="return confirm('Are you sure you want to logout?');" -->
        </div>
    </header>

    <div>
        <ul class="list">
            <li><a href="<?php echo $appUrl; ?>/src/Views/admin/programes/index">Programs</a></li>
            <li><a href="<?php echo $appUrl; ?>/src/Views/admin/participants/index">Participants</a></li>
            <li><a href="<?php echo $appUrl; ?>/src/Views/admin/clubs/create">Create Club</a></li>
            <li><a href="<?php echo $appUrl; ?>/src/Views/admin/clubs/index">Clubs</a></li>
            <li><a href="<?php echo $appUrl; ?>/src/Views/admin/create">Create Admin</a></li>
            <li><a href="#" id="changepass">Change password</a></li>
            <li><a href="<?php echo $appUrl; ?>/src/Views/admin/delete?id=<?php echo $_SESSION['user_id']; ?>">Delete account</a></li>
        </ul>
    </div>

    <!-- Password Change Modal -->
    <div class="loginbackground" style="display: none;">
        <form class="mx-auto changepass" id="loginModal" method="POST" style="display: none;">
            <span class="closelogin" id="closeModal" style="position: absolute; top: 10px; right: 20px; font-size: 2rem; cursor: pointer;">&times;</span>
            <h4 class="text-center mb-4">Change Your Password</h4>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Confirm Your Email</label>
                <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                    aria-describedby="emailHelp" required>
                <label for="exampleInputPassword1" class="form-label">Current Password</label>
                <input type="password" name="pass" class="form-control" id="exampleInputPassword1" required>
                <label for="exampleInputPassword2" class="form-label">New Password</label>
                <input type="password" name="newpass" class="form-control" id="exampleInputPassword2" required>
                <label for="exampleInputPassword3" class="form-label">Confirm New Password</label>
                <input type="password" name="confpass" class="form-control" id="exampleInputPassword3" required>
            </div>
            <button type="submit" value="save" name="save" class="btn btn-primary mt-4">SAVE</button>
            <p>Go to <a href="<?php echo $appUrl; ?>/src/Views/admin/dashboard">Dashboard</a></p>
        </form>
    </div>
    <!-- change password script -->
    <script src="<?php echo $appUrl; ?>/public/assets/JS/changepass.js"></script>


    <div class="content">
        <h1 class="text-center">Welcome Admin</h1>
        <div id="liveClock"></div>

        <?php if ($changePassMessage): ?>
            <div class="alert alert-info text-center"><?php echo $changePassMessage; ?></div>
        <?php endif; ?>
    </div>

    <script src="<?php $appUrl ?>/public/assets/JS/clock.js"></script>

    <!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>

    <script>
        function detectBackButton() {
            if (window.performance && window.performance.navigation.type === 2) {
                window.location.href = "<?php echo $appUrl; ?>/src/Views/admin/dashboard";
            }
        }
        // Call the function on page load
        window.onload = detectBackButton;
    </script>
</body>

</html>