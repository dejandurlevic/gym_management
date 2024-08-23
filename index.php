<?php
session_start();

if(isset($_SESSION['error'])) {
    echo '<div class="error">' . $_SESSION['error'] . '</div>';
    unset($_SESSION['error']); // We remove the message from the session after it is displayed
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .error {
            color: red;
            margin-bottom: 10px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <h1>Admin Login</h1>

    <form action="Models/login.php" method="post">
        Username: <input type="text" name="username">
        Password: <input type="password" name="password"> 
        <button type="submit">Login</button>
   </form>
    
</body>
</html>