<?php
require_once __DIR__ . '/../_init.php';

use App\Controllers\ProgramController;
use App\Controllers\ParticipantController;
use App\Controllers\UserController;

$programController = new ProgramController($con);
$participantController = new ParticipantController($con);
$userController = new UserController($con);

$user_id = $_SESSION['user_id'] ?? null;

// Get program ID from GET or SESSION
if (isset($_GET['id'])) {
    $program_id = (int)$_GET['id'];
    $_SESSION['program_id'] = $program_id;
} elseif (isset($_SESSION['program_id'])) {
    $program_id = (int)$_SESSION['program_id'];
} else {
    echo "<script>alert('Error Fetching Program ID'); window.location.href='" . $appUrl . "/src/Views/club/participants/index';</script>";
    exit();
}

// Get the program for this user using controller
$program = $programController->getProgramById($program_id);

// Check if the program exists and belongs to the user
if (!$program || $program['user_id'] != $user_id) {
    echo "<script>alert('Program not found or permission denied'); window.location.href='" . $appUrl . "/src/Views/club/participants/index';</script>";
    exit();
}
$program_name = $program['name'];

// Handle participant deletion using controller
if (isset($_POST['delete_participant'])) {
    $participant_id = $_POST['participant_id'] ?? null;

    // Validate that the participant belongs to this program and user
    $participantsResult = $participantController->getParticipantsByProgramId($program_id);
    $participantFound = false;
    if ($participantsResult) {
        while ($row = $participantsResult->fetch_assoc()) {
            if ($row['participant_id'] == $participant_id && $row['user_id'] == $user_id) {
                $participantFound = true;
                break;
            }
        }
    }
    if (!$participantFound) {
        echo '<script>alert("Invalid participant or permission denied.");</script>';
        exit();
    }

    if ($participantController->deleteParticipantById($participant_id)) {
        echo '<script>alert("Participant deleted successfully");</script>';
    } else {
        echo '<script>alert("Failed to delete participant");</script>';
    }
}

// Fetch participants for this program and user using controller
$participantsResult = $participantController->getParticipantsByProgramId($program_id);
$participants = [];
if ($participantsResult) {
    while ($row = $participantsResult->fetch_assoc()) {
        if ($row['user_id'] == $user_id) {
            $participants[] = $row;
        }
    }
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?php echo $appUrl; ?>/public/assets/images/cropped-GCU-Logo-circle.png">
    <title><?php echo htmlspecialchars($program_name); ?></title>
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
                        <h2 class="display-6">
                            <?php echo htmlspecialchars($program_name); ?>
                        </h2>
                        <span id="closeModal">&times;</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered text-center">
                                <tr>
                                   
                                    <td class="bg-dark text-white">Name</td>
                                    <td class="bg-dark text-white">Email</td>
                                    <td class="bg-dark text-white">Phone</td>
                                    <td class="bg-dark text-white">Branch</td>
                                    <td class="bg-dark text-white">Semester</td>
                                    <td class="bg-dark text-white">College</td>
                                    <td class="bg-dark text-white">Program Name</td>
                                    <td class="bg-dark text-white">Conducted By</td>
                                    <td class="bg-dark text-white">Delete</td>
                                </tr>
                                <?php
                                if (!empty($participants)) {
                                    foreach ($participants as $row) {
                                        ?>
                                        <tr>
                                            
                                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                                            <td><?php echo htmlspecialchars($row['phone']); ?></td>
                                            <td><?php echo htmlspecialchars($row['branch']); ?></td>
                                            <td><?php echo htmlspecialchars($row['sem']); ?></td>
                                            <td><?php echo htmlspecialchars($row['college']); ?></td>
                                            <td><?php echo htmlspecialchars($program_name); ?></td>
                                            <td>
                                                <?php
                                                $user = $userController->getUserById($row['user_id']);
                                                echo $user ? htmlspecialchars($user['name']) : 'N/A';
                                                ?>
                                            </td>
                                            <td>
                                                <form action="" method="POST" onsubmit="return confirm('Are you sure you want to delete this participant data?');">
                                                    <input type="hidden" name="participant_id" value="<?php echo htmlspecialchars($row['participant_id']); ?>">
                                                    <button type="submit" name="delete_participant" class="btn btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo '<tr><td colspan="10" class="text-center">No participants found.</td></tr>';
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
            window.location.href = '<?php echo $appUrl; ?>/src/Views/club/participants/index';
        });
    </script>
    <script src="<?php echo $appUrl; ?>/public/assets/JS/printpage.js"></script>
</body>

</html>