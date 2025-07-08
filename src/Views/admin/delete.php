<?php

require_once __DIR__ . '/_init.php';

use App\Controllers\UserController;

$userController = new UserController($con);

if (!isset($_GET['id'])) {
    echo '<script>alert("User ID not provided.");</script>';
    exit();
}

$message = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {

    $message = $userController->deleteUserByIdAndEmail($_POST);

    if ($message === "Account deleted successfully.") {
        echo "<script>alert('Account deleted successfully.');</script>";
        echo "<script>window.location.href='". $appUrl . "/src/Views/auth/logout' </script>";
    } else {
        echo "<script>alert('" . $message . "');</script>";
        echo "<script>window.location.href='". $appUrl . "/src/Views/admin/delete' </script>";
    }
}


?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?php echo $appUrl; ?>/public/assets/images/cropped-GCU-Logo-circle.png">
    <title>Delete Your Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #ffffff;
        }

        .form-container {
            max-width: 500px;
            margin: 100px auto;
            padding: 30px;
            border-radius: 15px;
            background-color: #f9f9f9;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .btn-danger {
            width: 100%;
        }

        .closelogin {
            font-size: 30px;
            position: absolute;
            right: 20px;
            top: 15px;
            cursor: pointer;
            color: #000;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="form-container position-relative">
            <span class="closelogin" id="closeModal">&times;</span>
            <h4 class="text-center mb-4">Delete Your Account Permanently</h4>
            <?php if ($message): ?>
                <div class="alert alert-info text-center"><?php echo $message; ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Confirm Username</label>
                    <input type="text" name="username" class="form-control" id="username" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Confirm Email</label>
                    <input type="email" name="email" class="form-control" id="email" required>
                </div>
                <div class="mb-3">
                    <label for="pass" class="form-label">Enter Password</label>
                    <input type="password" name="pass" class="form-control" id="pass" required>
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" onclick="togglePassword()" id="showPass">
                        <label class="form-check-label" for="showPass">Show Password</label>
                    </div>
                </div>
                <button type="submit" name="submit" class="btn btn-danger">DELETE</button>
                <p class="mt-3 text-center">Go to <a href="<?php echo $appUrl; ?>/src/Views/admin/dashboard">Dashboard</a></p>
            </form>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passField = document.getElementById("pass");
            passField.type = passField.type === "password" ? "text" : "password";
        }

        document.getElementById('closeModal').addEventListener('click', () => {
            window.location.href = "<?php echo $appUrl; ?>/src/Views/admin/dashboard";
        });
    </script>
</body>

</html>
