<?php
    require 'config.php';
?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Recipe Central</title>
    <link rel="shortcut icon" href="favicon.ico" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous" />
</head>

<body>
    <!-- Navbar -->
    <div id="navbar">
        <?php echo getNav(); ?>
    </div>

    <section style="padding-top: 5rem; padding-bottom: 2rem;">
        <div class="container-fluid">
            <div class="text-center">
                <h3>Advanced Search</h3><hr/>
            </div>
            <form id="searchForm" class="col-6 mx-auto form">
                <div class="row">
                    <div class="col-md-12 form-group input-group">
                        <input type="text" id="searchText" name="searchText" class="form-control" placeholder="Enter Search">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group input-group">
                        <div class="col-md-4 form-group">
                            <select name="searchType" class="custom-select">
                                <option value="recipename">Recipe Name</option>
                                <option value="username">Chef</option>
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <select name="recipetype" class="custom-select">
                                <option selected="true" value="">All Recipes</option>
                                <option value="Appetizers and Snacks">Appetizers and Snacks</option>
                                <option value="Main Dishes">Main Dishes</option>
                                <option value="World Cuisine">World Cuisine</option>
                                <option value="Fruits and Vegetables">Fruits and Vegetables</option>
                                <option value="Soups, Stews and Chili Recipes">Soups, Stews and Chili Recipes</option>
                                <option value="Side Dish">Side Dish</option>
                                <option value="Meat and Poultry">Meat and Poultry</option>
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <input type="submit" id="searchSubmit" name="searchBtn" class="btn btn-primary btn-block" value="Search" data-target="searchButton">
                        </div>
                    </div>
                <div>
            </form>
        </div>
    </section>

    <section class="bg-light" style="min-height: 67.5vh;">
        <div class="container-fluid">
            <div class="text-center">
                <h3>Results</h3><hr/>
            </div>
            <div class="row" id="results"></div>
        </div>
    </section>

    <!-- Back to top button -->
    <button type="button" class="btn btn-primary btn-floating btn-lg" id="btn-back-to-top">
        <i class="fas fa-arrow-up"></i>
    </button>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
    <script src="js/scroll-to-top.js"></script>
    <script src="js/ajax-requests.js"></script>

    <script>
        function getUrlParameter(sParam) {
            var sPageURL = window.location.search.substring(1), sURLVariables = sPageURL.split('&'), sParameterName, i;
            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');
                if (sParameterName[0] === sParam) {
                    return typeof sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
                }
            }
            return false;
        }

        $(document).ready(function (){
            let searchText = getUrlParameter("searchText");
            if(searchText !== false){
                $("#searchText").val(searchText);
                $('#searchForm').submit();
            }
        });
    </script>
</body>
</html>
