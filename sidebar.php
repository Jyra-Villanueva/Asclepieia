<!-- sidebar.php -->

<div class="sidebar">
    <img src="logo/logo.png" alt="Logo">
    <a href="find_plants.php" class="<?php echo (basename($_SERVER['SCRIPT_FILENAME']) == 'find_plants.php') ? 'active' : ''; ?>">Find</a>
    <a href="plants.php" class="<?php echo (basename($_SERVER['SCRIPT_FILENAME']) == 'plants.php') ? 'active' : ''; ?>">Plants</a>
    <a href="login.php" class="<?php echo (basename($_SERVER['SCRIPT_FILENAME']) == 'logout.php') ? 'active' : ''; ?>">Logout</a>
    <?php
    if (isset($_SESSION['admin'])) {
        echo '<a href="login.php">Logout</a>';
    }
    ?>
</div>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap">
    <title>Document</title>
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }

        .sidebar {
            position: fixed;
            height: 100%;
            width: 200px;
            top: 0;
            left: 0;
            background-color: #5C8374;
            padding-top: 56px;
            color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            text-align: left;
        }

        .sidebar img {
            width: 150px; 
            margin-bottom: 10px;
            border-radius: 50%;
        }

        .sidebar a.navbar-brand {
            padding: 16px 16px 16px 32px;
            text-decoration: none;
            font-size: 18px;
            font-weight: bold; 
            color: #fff;
            display: block;
        }

        .sidebar a {
            padding: 16px 16px 16px 32px;
            text-decoration: none;
            font-size: 18px;
            color: #fff;
            display: block;
            transition: background-color 0.3s;
        }

        .sidebar a:hover {
            background-color: #435d56; 
        }

        .sidebar a.active {
            background-color: #435d56;
            color: #fff; 
        }

        body {
            margin-left: 200px;
            padding-top: 56px;
            transition: margin-left 0.3s;
        }
    </style>
</head>
<body>
        
</body>
</html>
