<?php
require("config.php");


session_start();

if (!isset($_SESSION["username"]) && !isset($_SESSION['password'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $username = $_SESSION["username"];

    $updateStmt = $pdo->prepare("UPDATE user SET firstname=?, lastname=?, email=? WHERE username=?");
    $updateStmt->execute([$firstname, $lastname, $email, $username]);

    header("Location: profile.php");
    exit();
}

$pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$username = $_SESSION["username"];

$userStmt = $pdo->prepare("SELECT firstname, lastname, email FROM user WHERE username = ?");
$userStmt->execute([$username]);
$userInfo = $userStmt->fetch(PDO::FETCH_ASSOC);
?>
<?php require("navbar.php");
include("bg.php");?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h2>Edit Profile:</h2>
        </div>
        <div class="card-body">
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="form-group">
                    <label for="firstname">First Name:</label>
                    <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $userInfo['firstname']; ?>">
                </div>
                <div class="form-group">
                    <label for="lastname">Last Name:</label>
                    <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $userInfo['lastname']; ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $userInfo['email']; ?>">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
