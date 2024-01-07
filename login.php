<?php
require_once 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === 'admin' && $password === 'Admin@123') {
        $_SESSION['admin'] = true;
        header("Location: find_plants.php");
        exit();
    }

    $stmt = $conn->prepare("SELECT password FROM user WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->bind_result( $hashedPassword);

    if ($stmt->fetch() && password_verify($password, $hashedPassword)) {
        $_SESSION['username'] = $username;

        $auth_token = bin2hex(random_bytes(32));
        setcookie('user_id', $user_id, time() + 86400 * 30, '/');
        setcookie('auth_token', $auth_token, time() + 86400 * 30, '/');

        header("Location: questionnaire.php");
        exit();
    } else {
        $errorMessage = "Invalid username or password";
    }

    $stmt->close();
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
            background-image: url('logo/bg.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed; 
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
            <h2 class="mb-4">Login</h2>
            <?php
            if (isset($errorMessage)) {
                echo "<div class='alert alert-danger'>$errorMessage</div>";
            }
            ?>
            <form action="login.php" method="POST">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" name="login" class="btn btn-primary">Login</button>
                <br><label>Don't have an account?</label>
                <a href="register.php">Register Here</a>
            </form>
        </div>
    </div>
</body>
</html>
