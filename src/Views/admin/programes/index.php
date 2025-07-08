<?php

require_once __DIR__ . '/../_init.php';

use App\Controllers\ProgramController;
use App\Controllers\ClubController;
use App\Controllers\UserController;

$programController = new ProgramController($con);
$clubController = new ClubController($con);
$userController = new UserController($con);

if (isset($_POST['delete_program_id'])) {
    $program_id = $_POST['delete_program_id'];
    if ($programController->deleteProgram($program_id)) {
        echo '<script>alert("Program deleted successfully")</script>';
        echo '<script>window.location.href = "./currentprograms";</script>';
        exit;
    } else {
        echo '<script>alert("Failed to delete the program")</script>';
    }
}



$resClubs = $clubController->getClubs();
$res2 = $programController->getPrograms();  

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?php echo $appUrl; ?>/public/assets/JS/printpage.js/assets/images/cropped-GCU-Logo-circle.png">
    <title>All Programs</title>
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
                                Select Club
                            </button>
                            <button class="btn btn-outline-success" type="button" onclick="window.location.href='<?php echo $appUrl; ?>/src/Views/admin/programes/create'"
                                aria-expanded="false">
                                Create Program
                            </button>

                            <ul class="dropdown-menu bg-dark">
                                <?php while ($club = mysqli_fetch_assoc($resClubs)) { ?>
                                    <li>
                                        <a href="<?php echo $appUrl; ?>/src/Views/admin/programes/filter?id=<?php echo $club['user_id']; ?>"
                                            style="color:white;" class="dropdown-item mb-2 text-center drop-link">
                                            <?php echo htmlspecialchars($club['name']); ?>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                        <h2 class="display-6">All New Events</h2>
                        <span id="closeModal">&times;</span>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered text-center">
                                <tr>
                                    <td class="bg-dark text-white"> ID </td>
                                    <td class="bg-dark text-white"> Program Name </td>
                                    <td class="bg-dark text-white"> Date </td>
                                    <td class="bg-dark text-white"> Time </td>
                                    <td class="bg-dark text-white"> Venue</td>
                                    <td class="bg-dark text-white"> Theme</td>
                                    <td class="bg-dark text-white"> Staff-Coordinator </td>
                                    <td class="bg-dark text-white"> Phone</td>
                                    <td class="bg-dark text-white"> Student-Coordinator</td>
                                    <td class="bg-dark text-white"> Phone</td>
                                    <td class="bg-dark text-white"> Conducted By</td>
                                    <td class="bg-dark text-white"> Delete</td>
                                </tr>
                                <tr>

                                    <?php
                                    while ($row = mysqli_fetch_assoc($res2)) {
                                    ?>
                                <tr>
                                    <td>
                                        <?php echo $row['program_id']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['name']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['date']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['time']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['venue']; ?>
                                    </td>
                                    <td>
                                        <?php
                                        $row0 = $programController->getProgramImage($row['program_id']);
                                        if ($row0 && $row0['image']) {
                                            echo '<img class="admin-img" src="' . $appUrl . "/public/" . $row0['image'] . '" width="90px" height="auto" alt="image">';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo $row['staff_coordinator']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['phone1']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['student_coordinator']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['phone2']; ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo $userController->getUserNameById($row['user_id']);
                                        ?>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-danger"
                                            onclick="confirmDelete(<?php echo $row['program_id']; ?>)">delete</a>
                                    </td>
                                    <form id="deleteForm" method="POST">
                                        <input type="hidden" name="delete_program_id" id="deleteProgramId">
                                    </form>
                                </tr>
                            <?php
                                    }
                            ?>

                            </tr>
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
            window.location.href = '<?php echo $appUrl; ?>/src/Views/admin/dashboard';
        });


        function confirmDelete(programId) {
            if (confirm('Please note that deleting this program will irreversibly remove associated participant data. Are you absolutely certain you wish to proceed with this action?')) {
                // Set the program_id to the hidden input field and submit the form
                document.getElementById('deleteProgramId').value = programId;
                document.getElementById('deleteForm').submit();
            }
        }
    </script>
    <script src="<?php echo $appUrl; ?>/public/assets/JS/printpage.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>