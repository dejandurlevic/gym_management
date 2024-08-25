<?php
require_once 'Models/Database.php';
session_start();
 
$db = new Database();
$database = $db->database;

$result = $database->query("SELECT members.*, 
training_plans.name AS training_plan_name,
trainers.fullName AS trainer_first_name,
trainers.last_name AS trainer_last_name
FROM members 
LEFT JOIN training_plans ON members.training_plan_id = training_plans.plan_id
LEFT JOIN trainers ON members.trainer_id = trainers.trainer_id;");

if ($result->num_rows > 0) {
    $rows = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $rows = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <title>Members</title>
    <style>
        .table-responsive {
            margin-top: 20px;
        }
        .table thead th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .table tbody tr:hover {
            background-color: #f1f1f1;
        }
        .nav-link.active {
            font-weight: bold;
            color: #007bff !important;
        }
        .btn-delete {
            cursor: pointer;
        }
        img {
            border-radius: 8px;
        }
    </style>
</head>
<body>

<?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php 
            echo $_SESSION['success_message'];
            unset($_SESSION['success_message']);
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
    </div>
<?php endif; ?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Gym Management</a>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="dashboard.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="members.php">Members</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="trainers.php">Trainers</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mt-4">Members List</h2>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Trainer</th>
                            <th>Photo</th>
                            <th>Training Plan</th>
                            <th>Access Card</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($rows)) : ?>
                            <?php foreach ($rows as $row) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['first_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['last_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td><?php echo htmlspecialchars($row['phone_number']); ?></td>
                                    <td>
                                        <?php 
                                            $trainer_name = $row['trainer_first_name'] ? $row['trainer_first_name'] . ' ' . $row['trainer_last_name'] : 'No Trainer';
                                            echo htmlspecialchars($trainer_name);
                                        ?>
                                    </td>
                                    <td><img style="width: 60px;" src="<?php echo htmlspecialchars($row['photo_path']); ?>" alt="User Photo" /></td>
                                    <td>
                                        <?php 
                                            $training_plan = $row['training_plan_name'] ? $row['training_plan_name'] : 'No Plan';
                                            echo htmlspecialchars($training_plan);
                                        ?>
                                    </td>
                                    <td><a target="_blank" href="<?php echo htmlspecialchars($row['access_card_pdf_path']); ?>">Access Card</a></td>
                                    <td>
                                        <?php
                                            $created_at = strtotime($row['created_at']);
                                            echo date("d/m/Y", $created_at);
                                        ?>
                                    </td>
                                    <td>
                                        <form action="Models/delete_members.php" method="POST">
                                            <input type="hidden" name="member_id" value="<?php echo htmlspecialchars($row['member_id']); ?>">
                                            <button type="submit" class="btn btn-danger btn-sm btn-delete">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="10" class="text-center">There are no members in the database</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
