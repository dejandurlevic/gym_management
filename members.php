<?php
require_once 'Models/Database.php';

$db = new Database();
$database = $db->database;

$result = $database->query("SELECT * FROM members");

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
</head>
<body>

<nav>
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="dashboard.php">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="members.php">Members</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Logout</a>
        </li>
    </ul>
</nav>

<div class="row">
    <div class="col-md-12">
        <h2>Members list</h2>

        <table class="table table-striped">
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
                            <td><?php echo htmlspecialchars($row['trainer_id']); ?></td>
                            <td><img style="width: 60px;" src="<?php echo htmlspecialchars($row['photo_path']); ?>" alt="User Photo" /></td>
                            <td><?php echo htmlspecialchars($row['training_plan_id']); ?></td>
                            <td><a target="_blank" href="<?php echo htmlspecialchars($row['access_card_pdf_path']); ?>">Access Card</a></td>
                            <td>
                                <?php
                                $created_at = strtotime($row['created_at']);
                                echo date("d/m/Y", $created_at);
                                ?>
                            </td>
                            <td><button>DELETE</button></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="10">There are no users in the database</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
