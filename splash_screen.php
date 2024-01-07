
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Splash Screen</title>
    <style>
        body {
            background-color: #f0f0f0;
            text-align: center;
            font-size: larger;
            font-weight: 700;
            font-family: 'Montserrat', sans-serif;
            position: relative;
            margin: 0;
            overflow: hidden; 
        }

        img {
            max-width: 100%;
            height: auto;
            margin: 0 auto; 
        }

        .get-started-button {
            background-color: #435d56;
            color: #fff;
            padding: 30px 70px;
            text-decoration: none;
            border-radius: 100px;
            font-size: 20px;
            position: absolute; 
            top: 60%; 
            left: 50%; 
            transform: translate(-50%, -50%); 
            transition: background-color 0.3s ease; 
        }

        .get-started-button:hover {
            background-color: #E9E9E9;
            color: #435d56; 
        }
    </style>
</head>
<body>

    <img src="logo/splash_screen.png" alt="Splash Image">

    <a href="login.php" class="get-started-button">Get Started</a>

</body>
</html>
