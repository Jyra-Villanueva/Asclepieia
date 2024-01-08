<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            background-image: url('logo/bg.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed; 
            margin: 0; 
            padding: 0; 
            padding: 80px;
            margin: 20px;
            background-color: #000000;
            color: #ffffff;
        }

        #Welcome{
            color: #ffffff;
            font-size: 40px;
            margin-bottom: 20px;
        }

        .list-container {
            list-style-type: none;
            padding: 0;
            font-size: 20px;
        }

        .list-item {
            background-color: white;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 10px;
            overflow: hidden; 
            transition: background-color 0.3s;
            cursor: pointer;
        }

        .list-item:hover {
            text-decoration: none;
            background-color: #435d56;
            color: #ffffff;
        }

        a:hover {
            text-decoration: none;
            color: #ffffff;
        }
        p:hover{
            color: #ffffff;
            text-decoration: none;
        }

        #search-bar {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            font-size: 18px;
            border: 2px solid #ffffff;
            border-radius: 5px;
            background-color:#ffffff ;
            color: #000000;
        }
    </style>

    <script>
        function filterDiseases() {
            var input, filter, ul, li, p, i, txtValue;
            input = document.getElementById('search-bar');
            filter = input.value.toUpperCase();
            ul = document.getElementsByClassName('list-container')[0];
            li = ul.getElementsByClassName('list-item');

            for (i = 0; i < li.length; i++) {
                p = li[i].getElementsByTagName('p')[0];
                txtValue = p.textContent || p.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = '';
                } else {
                    li[i].style.display = 'none';
                }
            }
        }
    </script>

    <?php include("navbar.php"); ?>
    <title>Herbal Plant Website</title>
</head>
<body>
    <h1 id='Welcome'>Welcome to Herbal Plant Website</h1>

    <!-- Add the search bar -->
    <input type="text" id="search-bar" onkeyup="filterDiseases()" placeholder="Search for diseases">

    <ul class="list-container">
        <?php
            // Your existing PHP code
            $jsonData = file_get_contents('disease.json');
            $diseases = json_decode($jsonData, true);

            foreach ($diseases as $disease) {
                echo '<li class="list-item">';
                echo '<a href="pages_disease.php?name=' . urlencode($disease['name']) . '">';
                echo '<p>' . $disease['description'] . '</p>';
                echo '</a>';
                echo '</li>';
            }
        ?>
    </ul>
</body>
</html>