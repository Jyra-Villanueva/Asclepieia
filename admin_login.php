//admin_login.php

<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the entered credentials match the admin user
    if ($username === 'admin' && $password === 'Admin@123') {
        $_SESSION['admin'] = true;
        header("Location: plants.php");
        exit();
    } else {
        $error_message = "Invalid username or password.";
        // Instead of redirecting, you can display an error message.
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <title>Login - Plant Website</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">


<style>
    body {
        background-color: #5C8374;
        color: #5C8374;
        margin: 0; 
        padding: 0; 
    }
    .container {
        max-width: 1300px; 
        height: 500px; 
        margin: auto;
        background-color: #FFFFFF;
        
        border-radius: 10px;
        margin-top: 100px;
        position: relative;
        display: flex;
        border-radius: 10px;
        padding: 0;
    }
    .card-img-left {
        width: 40%;
        object-fit: cover;
        border-radius:10px 0px 0px 10px;
    }
    .text-container {
        flex: 1;
        padding: 20px;
    }
</style>
</head>

<body>
    <div class="container">
  
        <img src="logo/ascla2.png" alt="Your Image" class="card-img-left">
        <div class="text-container">
        <h2 class="mb-4">Admin Login</h2>
            <!-- <h2>Login</h2> -->
            <?php
        if (isset($error_message)) {
            echo "<div class='alert alert-danger'>$error_message</div>";
        }
        ?>
        <form action="admin_login.php" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        </div>
    </div>
</body>



</html>
