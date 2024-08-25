<?php
require_once 'Models/Database.php';
session_start();

// Proverite da li je admin prijavljen
if (!isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link 
        rel="stylesheet" 
        href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" 
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" 
        crossorigin="anonymous"
    />
    <link 
        rel="stylesheet" 
        href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" 
        type="text/css"
    />
    <title>Admin Dashboard</title>
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

<div class="container mt-5">
    <nav>
        <ul class="nav mb-4">
            <li class="nav-item">
                <a class="nav-link" href="dashboard.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="members.php">Members</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="trainers.php">Trainers</a>
            </li>
        </ul>
    </nav>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4>Register Member</h4>
                </div>
                <div class="card-body">
                    <form action="Models/register_member.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="first_name">First Name:</label>
                            <input type="text" name="first_name" id="first_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name:</label>
                            <input type="text" name="last_name" id="last_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="phone_number">Phone Number:</label>
                            <input type="text" name="phone_number" id="phone_number" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="training_plan_id">Training Plan:</label>
                            <select name="training_plan_id" id="training_plan_id" class="form-control" required>
                                <?php
                                $db = new Database();
                                $database = $db->database;
                                $result = $database->query("SELECT * FROM training_plans");

                                if ($result->num_rows > 0) {
                                    $assocs = $result->fetch_all(MYSQLI_ASSOC);
                                    foreach ($assocs as $row) {
                                        $id = $row['plan_id'];
                                        $name = $row['name'];
                                        echo "<option value=\"$id\">$name</option>";
                                    }
                                } else {
                                    echo "<option disabled>No training plans found.</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <input type="hidden" name="photo_path" id="photoPathInput">
                        <div id="dropzone-upload" class="dropzone"></div>
                        <button class="btn btn-primary mt-3" type="submit">Register Member</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h4>Register Trainer</h4>
                </div>
                <div class="card-body">
                    <form action="Models/register_trainer.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="fullName">Full Name:</label>
                            <input type="text" name="fullName" id="fullName" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name:</label>
                            <input type="text" name="last_name" id="last_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="phone_number">Phone Number:</label>
                            <input type="text" name="phone_number" id="phone_number" class="form-control" required>
                        </div>
                        <button class="btn btn-success mt-3" type="submit">Register Trainer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>

<script>
    Dropzone.options.dropzoneUpload = {
        url: "Models/upload_photo.php",
        paramName: "photo",
        maxFilesize: 20, // MB
        acceptedFiles: "image/*",
        init: function() {
            this.on("success", function(file, response) {
                const jsonResponse = JSON.parse(response);
                if (jsonResponse.success) {
                    document.getElementById('photoPathInput').value = jsonResponse.photo_path;
                } else {
                    console.error(jsonResponse.error);
                }
            });
        }
    };
</script>

</body>
</html>
