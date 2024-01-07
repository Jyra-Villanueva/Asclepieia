<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $confirm_password = $_POST['confirm_password'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $birthday = $_POST['birthday'];  
    $image = ''; 
    $gender = $_POST['gender'];

    if (!password_verify($confirm_password, $password)) {
        echo "Passwords do not match!";
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO user (username, password, firstname, lastname, email, birthday, image, gender) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('ssssssss', $username, $password, $firstname, $lastname, $email, $birthday, $image, $gender);

    if ($stmt->execute()) {
        header("Location: login.php"); 
        exit();
    } else {
        echo "Registration failed!";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Plant Website</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- <style>
        body {
            background-color: #5C8374;
            color: white;
            padding: 20px;
        }
        .container {
            max-width: 400px;
            margin: auto;
            background-color: #445D48;
            padding: 20px;
            border-radius: 10px;
            margin-top: 50px;
        }
    </style> -->


    <style>
        body {
            background-image: url('logo/bg.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed; 
            color: #5C8374;
            margin: 0;  
            color: white;
            padding: 20px;
            font-family: 'Montserrat', sans-serif;
        }

        .container {
            max-width: 600px; 
            margin: auto;
            background-color: #90A495;
            padding: 20px;
            border-radius: 10px;
            margin-top: 50px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input,
        select {
            width: 100%;
            height: 40px;
            padding: 10px;
            border: 1px solid #225533; 
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #90A495;
            color: #225533; 
            cursor: pointer;
        }

        button:hover {
            background-color: #679583; 
        }

        .error-message {
            color: #FF6347; /* Red error message */
            margin-top: 5px;
        }

        h2 {
            text-align: center;
        }

        .logo {
            width: 100px; /* Adjust the size accordingly */
            height: auto;
            margin-bottom: 20px;
        }

        .progress-bar {
            width: 100%;
            height: 20px;
            background-color: #225533; 
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .progress-step {
            width: 33.33%;
            height: 100%;
            background-color: #679583; 
            border-radius: 5px;
        }
    </style>

</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <form action="register.php" method="POST">
        <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
<div class="form-group">
    <label for="confirm_password">Confirm Password:</label>
    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
</div>

            <div class="form-group">
                <label for="firstname">First Name:</label>
                <input type="text" class="form-control" id="firstname" name="firstname" required>
            </div>
            <div class="form-group">
                <label for="lastname">Last Name:</label>
                <input type="text" class="form-control" id="lastname" name="lastname" required>
            </div>

            <div class="form-group">
    <label for="birthday">Birthday:</label>
    <input type="date" class="form-control" id="birthday" name="birthday" required>
</div>


          
            <div class="form-group">
                <label for="gender">Gender:</label>
                <select class="form-control" id="gender" name="gender" required>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>
</body>
</html>
