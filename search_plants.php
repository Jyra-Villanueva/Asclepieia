
<div class="container mt-3">
    <form action="find_plants.php" method="GET" class="mb-3">
        <div class="form-row">
            <div class="col">
                <label for="searchPlant">Search for a Plant:</label>
                <input type="text" class="form-control" id="searchPlant" name="searchPlant" placeholder="Enter plant name">
                <div id="searchResults" class="list-group"></div>
            </div>
        </div>
    </form>

    <div id="searchResults" class="list-group"></div>

        <script>
            function handleInput() {
                var searchPlantValue = document.getElementById('searchPlant').value.trim();

                if (searchPlantValue !== '') {
                    fetchMatchingPlants(searchPlantValue.toLowerCase());
                } else {
                    document.getElementById('searchResults').innerHTML = '';
                }
            }

            function fetchMatchingPlants(searchValue) {
                fetch('plant_json.json')
                    .then(response => response.json())
                    .then(data => {
                        var herbArray = Array.isArray(data.herb) ? data.herb : Object.values(data.herb);

                        var matchingPlants = herbArray.filter(function (plant) {
                            return plant.name.toLowerCase().startsWith(searchValue);
                        });

                        displayMatchingPlants(matchingPlants);
                    })
                    .catch(error => console.error('Error fetching data:', error));
            }

            function displayMatchingPlants(plants) {
                var searchResultsContainer = document.getElementById('searchResults');
                searchResultsContainer.innerHTML = '';

                if (plants.length > 0) {
                    var resultList = document.createElement('ul');
                    resultList.classList.add('list-group');

                    plants.forEach(function (plant) {
                        var listItem = document.createElement('li');
                        listItem.classList.add('list-group-item');

                        var link = document.createElement('a');
                        link.textContent = plant.name;
                        link.href = 'manage_plants.php?plant=' + encodeURIComponent(plant.name);

                        listItem.appendChild(link);
                        resultList.appendChild(listItem);
                    });

                    searchResultsContainer.appendChild(resultList);
                } else {
                    var noResultsItem = document.createElement('div');
                    noResultsItem.classList.add('list-group-item');
                    noResultsItem.textContent = 'No matching plants found.';
                    searchResultsContainer.appendChild(noResultsItem);
                }
            }

            document.getElementById('searchPlant').addEventListener('input', handleInput);

            document.getElementById('searchButton').addEventListener('click', function (event) {
                event.preventDefault(); 

                handleInput();
            });
        </script>
</div>
