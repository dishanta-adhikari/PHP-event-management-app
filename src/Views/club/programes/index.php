<?php
require_once __DIR__ . '/../_init.php';


use App\Controllers\UserController;
use App\Controllers\ProgramController;
use App\Controllers\ParticipantController;

$userController = new UserController($con);
$programController = new ProgramController($con);
$participantController = new ParticipantController($con);

$user_id = $_SESSION['user_id'];

// Handle program deletion using controller
if (isset($_POST['delete_program_id']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $program_id = $_POST['delete_program_id'];

    // Validate that the program belongs to the current user
    $program = $programController->getProgramById($program_id);
    if (!$program || $program['user_id'] != $user_id) {
        echo '<script>alert("Invalid program or permission denied.");</script>';
        echo '<script>window.location.href = "'.$appUrl.'/src/Views/club/programes";</script>';
        exit;
    }

    $delete_participants_result = $participantController->deleteParticipantsByProgramId($program_id);
    $delete_program_result = $programController->deleteProgram($program_id);
    $delete_result = $delete_participants_result && $delete_program_result;

    if ($delete_result) {
        echo '<script>alert("Program deleted successfully")</script>';
        echo '<script>window.location.href = "'.$appUrl.'/src/Views/club/programes/index";</script>';
        exit;
    } else {
        echo '<script>alert("Failed to delete the program")</script>';
        echo '<script>window.location.href = "'.$appUrl.'/src/Views/club/programes/index";</script>';
        exit;
    }
}

// Get all programs for this user using controller
$programs = $programController->getProgramsByUserId($user_id);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?php echo $appUrl; ?>/public/assets/images/cropped-GCU-Logo-circle.png">
    <title>My Programs</title>
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

        .card-footer-title {
            padding: 20px;
            border-radius: 7px;
            transition: 0.5s ease;
        }

        .card-footer-title:hover {
            background-color: black;
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
                        <h2 class="display-6">New Events</h2>
                        <span id="closeModal">&times;</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered text-center">
                                <tr>
                                    <td class="bg-dark text-white"> Program Name </td>
                                    <td class="bg-dark text-white"> Date </td>
                                    <td class="bg-dark text-white"> Time </td>
                                    <td class="bg-dark text-white"> Venue</td>
                                    <td class="bg-dark text-white"> Theme</td>
                                    <td class="bg-dark text-white"> Staff Coordinator </td>
                                    <td class="bg-dark text-white"> Phone </td>
                                    <td class="bg-dark text-white"> Student Coordinator</td>
                                    <td class="bg-dark text-white"> Phone </td>
                                    <td class="bg-dark text-white"> Conducted By</td>
                                    <td class="bg-dark text-white"> Delete</td>
                                </tr>
                                <?php if ($programs && $programs->num_rows > 0): ?>
                                    <?php foreach ($programs as $row): ?>
                                        <tr>
                                           
                                            <td>
                                                <?php echo htmlspecialchars($row['name']); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlspecialchars($row['date']); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlspecialchars($row['time']); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlspecialchars($row['venue']); ?>
                                            </td>
                                            <td>
                                                <?php if (!empty($row['image'])): ?>
                                                    <img class="admin-img" src="<?php echo $appUrl .'/public/'. htmlspecialchars($row['image']); ?>" width="90px"
                                                        height="auto" alt="image">
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php echo htmlspecialchars($row['staff_coordinator']); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlspecialchars($row['phone1']); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlspecialchars($row['student_coordinator']); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlspecialchars($row['phone2']); ?>
                                            </td>
                                            <td>
                                                <?php
                                                    $conductedBy = $userController->getUserNameById($row['user_id']);
                                                    echo htmlspecialchars($conductedBy);
                                                ?>
                                            </td>
                                            <td>
                                                <a href="#" class="btn btn-danger"
                                                    onclick="confirmDelete(<?php echo (int)$row['program_id']; ?>)">delete</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="12" class="text-center">No programs found.</td>
                                    </tr>
                                <?php endif; ?>
                            </table>
                            <form id="deleteForm" method="POST">
                                <input type="hidden" name="delete_program_id" id="deleteProgramId">
                            </form>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a onclick="printPage()" href="#" class="btn btn-secondary">Print</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    const closeModal = document.getElementById('closeModal');
    closeModal.addEventListener('click', () => {
        window.location.href = '<?php echo $appUrl; ?>/src/Views/club/dashboard';
    });

    function confirmDelete(programId) {
        if (confirm('Deleting this program will result in the permanent deletion of corresponding Participant Data. Are you certain you wish to proceed ?')) {
            document.getElementById('deleteProgramId').value = programId;
            document.getElementById('deleteForm').submit();
        } else {
            event.preventDefault();
        }
    }
</script>
<script src="<?php echo $appUrl; ?>/public/assets/JS/printpage.js"></script>

</html>