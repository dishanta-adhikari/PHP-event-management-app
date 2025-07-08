<?php

require_once __DIR__ . '/_init.php';

use App\Controllers\UserController;

$userController = new UserController($con);

$message = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    // Prepare values for controller
    $values = [
        'email' => trim($_POST['email'] ?? ''),
        'pass' => $_POST['password'] ?? '',
        // username is not in the form, but controller expects it, so fetch from session or user
        'username' => ''
    ];

    // Try to get username from session if available
    if (isset($_SESSION['user_id'])) {
        $user = $userController->getUserById($_SESSION['user_id']);
        if ($user && isset($user['user_name'])) {
            $values['username'] = $user['user_name'];
        }
    }

    $message = $userController->deleteUserByIdAndEmail($values);

    if ($message === "Account deleted successfully.") {
        echo "<script>alert('Account deleted successfully.');</script>";
        echo "<script>window.location.href='" . $appUrl . "/src/Views/auth/logout'</script>";
        exit;
    } else {
        echo "<script>alert('" . htmlspecialchars($message) . "');</script>";
        // Stay on the same page, or redirect as needed
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Club Account</title>
    <link rel="icon" href="<?php echo $appUrl; ?>/public/assets/images/cropped-GCU-Logo-circle.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body {
            background: #fff;
        }
        .delete-container {
            max-width: 400px;
            margin: 80px auto;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 0 10px #ddd;
            padding: 2rem 2.5rem 2rem 2.5rem;
            position: relative;
        }
        .delete-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #dd3737;
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .btn-danger {
            width: 100%;
            border-radius: 30px;
            background-color: #dd3737;
            border: none;
            font-weight: bold;
            transition: 0.3s;
        }
        .btn-danger:hover {
            background-color: #b71c1c;
        }
        .form-label {
            font-weight: 500;
        }
        .show-password {
            margin-top: 0.5rem;
            user-select: none;
        }
        .close-btn {
            position: absolute;
            top: 10px;
            right: 18px;
            font-size: 1.7rem;
            color: #888;
            cursor: pointer;
            transition: 0.2s;
        }
        .close-btn:hover {
            color: #dd3737;
            transform: scale(1.2);
        }
        .alert {
            margin-bottom: 1rem;
        }
        @media (max-width: 500px) {
            .delete-container {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="delete-container">
        <span class="close-btn" id="closeModal">&times;</span>
        <div class="delete-title">Delete Your Account</div>
        <?php if ($message): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        <form method="POST" autocomplete="off">
            <div class="mb-3">
                <label for="deleteEmail" class="form-label">Email</label>
                <input type="email" class="form-control" id="deleteEmail" name="email" required>
            </div>
            <div class="mb-3">
                <label for="deletePassword" class="form-label">Password</label>
                <input type="password" class="form-control" id="deletePassword" name="password" required>
                <div class="form-check show-password">
                    <input class="form-check-input" type="checkbox" id="showPasswordCheck" onclick="togglePassword()">
                    <label class="form-check-label" for="showPasswordCheck">Show Password</label>
                </div>
            </div>
            <button type="submit" name="delete" class="btn btn-danger mt-3">Delete Account</button>
            <p class="mt-3 text-center">Go to <a href="<?php echo $appUrl; ?>/src/Views/club/dashboard">Dashboard</a></p>
        </form>
    </div>
    <script>
        function togglePassword() {
            var x = document.getElementById("deletePassword");
            x.type = x.type === "password" ? "text" : "password";
        }
        document.getElementById('closeModal').onclick = function() {
            window.location.href = "<?php echo $appUrl; ?>/src/Views/club/dashboard";
        };
    </script>
</body>
</html>