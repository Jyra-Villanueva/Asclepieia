
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
            position: relative; /* Add relative positioning to the body */
            margin: 0; /* Remove default margin */
            overflow: hidden; /* Prevent horizontal scrollbar */
        }

        img {
            max-width: 100%;
            height: auto;
            margin: 0 auto; /* Center the image horizontally */
        }

        .get-started-button {
            background-color: #435d56;
            color: #fff;
            padding: 30px 70px;
            text-decoration: none;
            border-radius: 100px;
            font-size: 20px;
            position: absolute; /* Add absolute positioning to the button */
            top: 60%; /* Adjust the vertical position of the button */
            left: 50%; /* Center the button horizontally */
            transform: translate(-50%, -50%); /* Center the button precisely */
            transition: background-color 0.3s ease; /* Add a smooth color transition */
        }

        .get-started-button:hover {
            background-color: #E9E9E9;
            color: #435d56; /* Change background color on hover */
        }
    </style>
</head>
<body>

    <img src="logo/splash_screen.png" alt="Splash Image">

    <a href="login.php" class="get-started-button">Get Started</a>

</body>
</html>
