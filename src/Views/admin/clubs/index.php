<?php

require_once __DIR__ . '/../_init.php';

use App\Controllers\ClubController;
use App\Controllers\UserController;

$clubController = new ClubController($con);
$userController = new UserController($con);

if (isset($_POST['delete']) && isset($_POST['club_id'])) {
    $club_id = $_POST['club_id'];

    
    // Use the controller to get the club info and extract user_id
    $clubInfo = $clubController->getClubById($club_id);
    $user_id = isset($clubInfo['user_id']) ? $clubInfo['user_id'] : null;

    $resultClub = $clubController->deleteClubById($club_id);
    $resultUser = $user_id ? $userController->deleteUserByIdAndEmail($user_id) : false;
    $result = $resultClub && $resultUser;

    if ($result) {
        echo '<script>alert("Failed to delete club");</script>';
    } else {
        echo '<script>alert("Club data deleted successfully")</script>'; 
        echo '<script>window.location.href = "' . $appUrl . '/src/Views/admin/clubs/index.php";</script>';
        exit;
    }
}

// Use the controller to get all clubs
$clubs = $clubController->getClubs();

// Helper function to get full club info using controller/model
function getClubFullInfo($clubController, $club_id) {
    $club = $clubController->getClubById($club_id);
    return $club ? $club : [];
}
?>



<!-- html -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?php echo $appUrl;?>/public/assets/images/cropped-GCU-Logo-circle.png">
    <title>View Clubs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    <style>
        .card-header {
            display: flex;
            justify-content: space-between;
        }

        .card-header a {
            text-decoration: none;
            font-size: large;
            padding: 20px 0px 20px 0;
        }

        .card-header a:hover {
            color: #dd3737;
            transition: 0.5s ease;
        }

        .card-header a:hover {
            transform: scale(1.1);
        }

        #closeModal {
            font-size: 40px;
            cursor: pointer;
            transition: 0.5s ease;
        }

        #closeModal:hover {
            transform: scale(1.5);
        }

        .card-header h2 {
            text-align: start;
        }

        .card-footer {
            display: flex;
            justify-content: center;
            padding: 20px;
        }

        @media only screen and (max-width: 770px) {
            body {
                font-size: 0.7rem;
            }
        }

    </style>

</head>

<body class="bg-dark">
    <div class="container">
        <div class="row mt-5">
            <div class="column">
                <div class="card mt-5">
                    <div class="card-header">
                        <h2 class="display-6">Present Clubs Data</h2>
                        <span id="closeModal">&times;</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered text-center">
                                <tr>
                                    <td class="bg-dark text-white"> Club Name </td>
                                    <td class="bg-dark text-white"> Email </td>
                                    <td class="bg-dark text-white"> Phone </td>
                                    <td class="bg-dark text-white"> Delete </td>
                                </tr>
                                <?php
                                // Fetch all the clubs from the controller and display them
                                if (!empty($clubs)) {
                                    if ($clubs instanceof mysqli_result) {
                                        while ($row = $clubs->fetch_assoc()) {
                                            $club_id = isset($row['user_id']) ? $row['user_id'] : '';
                                            $name = isset($row['name']) ? $row['name'] : '';
                                            // Get full info using controller/model
                                            $clubInfo = getClubFullInfo($clubController, $club_id);
                                            $email = isset($clubInfo['email']) ? $clubInfo['email'] : '';
                                            $phone = isset($clubInfo['phone']) ? $clubInfo['phone'] : '';
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo htmlspecialchars($name); ?>
                                                </td>
                                                <td>
                                                    <?php echo htmlspecialchars($email); ?>
                                                </td>
                                                <td>
                                                    <?php echo htmlspecialchars($phone); ?>
                                                </td>
                                                <td>
                                                    <!-- Delete button -->
                                                    <form class="del" method="post" action="">
                                                        <input type="hidden" name="club_id" id="clubId_<?php echo htmlspecialchars($club_id); ?>"
                                                            value="<?php echo htmlspecialchars($club_id); ?>">
                                                        <input type="hidden" name="name" id="clubName_<?php echo htmlspecialchars($club_id); ?>"
                                                            value="<?php echo htmlspecialchars($name); ?>">
                                                        <button type="submit" name="delete" class="btn btn-danger"
                                                            onclick="return confirmDelete('<?php echo addslashes($club_id); ?>', '<?php echo addslashes($name); ?>')">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    } elseif (is_array($clubs)) {
                                        foreach ($clubs as $row) {
                                            $club_id = isset($row['user_id']) ? $row['user_id'] : '';
                                            $name = isset($row['name']) ? $row['name'] : '';
                                            $clubInfo = getClubFullInfo($clubController, $club_id);
                                            $email = isset($clubInfo['email']) ? $clubInfo['email'] : '';
                                            $phone = isset($clubInfo['phone']) ? $clubInfo['phone'] : '';
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo htmlspecialchars($name); ?>
                                                </td>
                                                <td>
                                                    <?php echo htmlspecialchars($email); ?>
                                                </td>
                                                <td>
                                                    <?php echo htmlspecialchars($phone); ?>
                                                </td>
                                                <td>
                                                    <!-- Delete button -->
                                                    <form class="del" method="post" action="">
                                                        <input type="hidden" name="club_id" id="clubId_<?php echo htmlspecialchars($club_id); ?>"
                                                            value="<?php echo htmlspecialchars($club_id); ?>">
                                                        <input type="hidden" name="name" id="clubName_<?php echo htmlspecialchars($club_id); ?>"
                                                            value="<?php echo htmlspecialchars($name); ?>">
                                                        <button type="submit" name="delete" class="btn btn-danger"
                                                            onclick="return confirmDelete('<?php echo htmlspecialchars($club_id, ENT_QUOTES); ?>', '<?php echo htmlspecialchars($name, ENT_QUOTES); ?>')">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a onclick="printPage()" href="#" class="btn btn-secondary">Print</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const closeModal = document.getElementById('closeModal');
        closeModal.addEventListener('click', () => {
            window.location.href = "<?php echo $appUrl; ?>/src/Views/admin/dashboard";
        });

        function confirmDelete(clubId, clubName) {
            return confirm('Are you sure you want to delete the club "' + clubName + '"?');
        }
    </script>
    <script src="<?php echo $appUrl; ?>/public/assets/JS/printpage.js"></script>
</body>

</html>