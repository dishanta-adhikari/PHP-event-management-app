<?php

require_once __DIR__ . '/../_init.php';

use App\Controllers\ProgramController;
use App\Controllers\ParticipantController;
use App\Controllers\UserController;

$programController = new ProgramController($con);
$participantController = new ParticipantController($con);
$userController = new UserController($con);

$user_id = $_SESSION['user_id'];

// Handle deletion of a participant
if (isset($_POST['delete_participant'])) {
    $participant_id = $_POST['participant_id'];

    // Validate that the participant belongs to the current user
    $participants = $participantController->getAllParticipants();
    $participantFound = false;
    if ($participants) {
        while ($row = $participants->fetch_assoc()) {
            if ($row['participant_id'] == $participant_id && $row['user_id'] == $user_id) {
                $participantFound = true;
                break;
            }
        }
    }

    if (!$participantFound) {
        echo '<script>alert("Invalid participant or permission denied.");</script>';
        echo '<script>window.location.href = "' . $appUrl . '/src/Views/club/participants/index";</script>';
        exit;
    }

    if ($participantController->deleteParticipantById($participant_id)) {
        echo '<script>alert("Participant deleted successfully");</script>';
        echo '<script>window.location.href = "' . $appUrl . '/src/Views/club/participants/index";</script>';
        exit;
    } else {
        echo '<script>alert("Failed to delete participant");</script>';
    }
}

// Fetch all participants for this user
$allParticipants = $participantController->getAllParticipants();
$participants = [];
if ($allParticipants) {
    while ($row = $allParticipants->fetch_assoc()) {
        if ($row['user_id'] == $user_id) {
            $participants[] = $row;
        }
    }
}

// Get all programs for this user
$programsResult = $programController->getProgramsByUserId($user_id);
$programs = [];
if ($programsResult) {
    while ($row = $programsResult->fetch_assoc()) {
        $programs[] = $row;
    }
}

// For mapping program_id to program name
$programNames = [];
foreach ($programs as $program) {
    $programNames[$program['program_id']] = $program['name'];
}

// For mapping user_id to user name (club name)
$userName = '';
$userData = $userController->getUserById($user_id);
if ($userData && is_array($userData)) {
    $userName = $userData['name'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Cache-Control" content="no-store" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?php echo $appUrl; ?>/public/assets/images/cropped-GCU-Logo-circle.png">
    <title>All Participants</title>
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

        .dropdown-item:hover {
            background-color: red;
            color: white;
        }

        @media screen and (max-width: 1205px) {
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
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Programs
                            </button>
                            <ul class="dropdown-menu bg-dark">
                                <?php foreach ($programs as $row1) { ?>
                                    <li>
                                        <a href="<?php echo $appUrl; ?>/src/Views/club/participants/filter?id=<?php echo urlencode($row1['program_id']); ?>" style="color:white;" class="dropdown-item mb-2 text-center drop-link">
                                            <?php echo htmlspecialchars($row1['name']) . "<br>"; ?>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                        <h2 class="display-6">All of My Participants</h2>
                        <span id="closeModal">&times;</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered text-center">
                                <tr>
                                    <td class="bg-dark text-white"> Name </td>
                                    <td class="bg-dark text-white"> Email </td>
                                    <td class="bg-dark text-white"> Phone </td>
                                    <td class="bg-dark text-white"> Branch </td>
                                    <td class="bg-dark text-white"> Semester </td>
                                    <td class="bg-dark text-white"> College </td>
                                    <td class="bg-dark text-white"> Program Name </td>
                                    <td class="bg-dark text-white"> Club Name </td>
                                    <td class="bg-dark text-white"> Delete </td>
                                </tr>
                                <?php foreach ($participants as $row): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                                        <td><?php echo htmlspecialchars($row['phone']); ?></td>
                                        <td><?php echo htmlspecialchars($row['branch']); ?></td>
                                        <td><?php echo htmlspecialchars($row['sem']); ?></td>
                                        <td><?php echo htmlspecialchars($row['college']); ?></td>
                                        <td>
                                            <?php
                                            $pid = $row['program_id'];
                                            echo isset($programNames[$pid]) ? htmlspecialchars($programNames[$pid]) : 'N/A';
                                            ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($userName); ?></td>
                                        <td>
                                            <form action="" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this participant data?');">
                                                <input type="hidden" name="participant_id"
                                                    value="<?php echo htmlspecialchars($row['participant_id']); ?>">
                                                <button type="submit" name="delete_participant"
                                                    class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
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
            window.location.href = '<?php echo $appUrl; ?>/src/Views/club/dashboard';
        });
    </script>
    <script src="<?php echo $appUrl; ?>/public/assets/JS/printpage.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>