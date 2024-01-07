<?php
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
            color:#fff;
            text-decoration-line: none;
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
        #title:hover{
            background-color: #5C8374;
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <img src="logo/asclepieia..png" alt="Logo">
        <a id="title" class="navbar-brand" href="#">Plant Website</a>
        <a href="homepage.php" class="<?php echo (basename($_SERVER['SCRIPT_FILENAME']) == 'homepage.php') ? 'active' : ''; ?>">Home</a>
        <a href="display_plants.php" class="<?php echo (basename($_SERVER['SCRIPT_FILENAME']) == 'display_plants.php') ? 'active' : ''; ?>">Plants</a>
        <a href="identify_insert.php" class="<?php echo (basename($_SERVER['SCRIPT_FILENAME']) == 'identify_insert.php') ? 'active' : ''; ?>">Plant Identification</a>
        <a href="disease_index.php" class="<?php echo (basename($_SERVER['SCRIPT_FILENAME']) == 'disease_index.php') ? 'active' : ''; ?>">Diseases</a>
        <a href="create_blog.php" class="<?php echo (basename($_SERVER['SCRIPT_FILENAME']) == 'create_blog.php') ? 'active' : ''; ?>">Create Post</a>
        <a href="profile.php" class="<?php echo (basename($_SERVER['SCRIPT_FILENAME']) == 'profile.php') ? 'active' : ''; ?>">Profile</a>
    </div>

</body>

</html>
