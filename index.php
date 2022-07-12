<?php
    require 'config.php';
    $database = new Database();
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

    <!-- Header -->
    <header class="masthead text-white text-center">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-xl-9 mx-auto">
                    <h1 class="mb-5">Start finding new recipes today!</h1>
                </div>
                <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">

                <!-- Search recipe form -->
                <form action="advanced-search.php" method="get" class="form">
                    <div class="form-row">
                        <div class="col-12 col-md-9 mb-2 mb-md-0">
                            <input class="form-control form-control-lg" type="search" name="searchText" placeholder="Enter a recipe name">
                        </div>
                        <div class="col-12 col-md-3">
                            <button class="btn btn-block btn-lg btn-primary">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </header>

    <!-- Icons Grid -->
    <section class="features-icons bg-light text-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-sm-6">
                    <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
                        <div class="features-icons-icon d-flex">
                            <i class="fas fa-heart m-auto text-primary" role="button"></i>
                        </div>
                        <h3>Nutrition Facts</h3>
                        <p class="lead mb-0">View calories, protein, carbs, etc.</p>
                    </div>
                </div>

                <div class="col-lg-6 col-sm-6">
                    <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
                        <div class="features-icons-icon d-flex">
                            <i class="fas fa-bookmark m-auto text-primary" role="button"></i>
                        </div>
                        <h3>Bookmark</h3>
                        <p class="lead mb-0">Save recipes to view later</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newest Recipes Section   -->
    <section>
        <div class="container-fluid">
            <div class="text-center">
                <h3>Newest Recipes</h3><hr/>
            </div>

            <div class="row">
                <?php
                    $database->query("SELECT Recipes.*, Users.userName FROM (Users INNER JOIN Recipes ON Users.userID = Recipes.chefID) ORDER BY recipeID DESC LIMIT 12;");
                    echo getRecipeCards($database, $database->results());
                ?>
            </div>
        </div>
    </section>

    <!-- Random Recipes Section   -->
    <section class="bg-light" style="min-height: 67.5vh;">
        <div class="container-fluid">
            <div class="text-center">
                <h3>Random Recipes</h3><hr/>
                <div class="row">
                    <button id="rerollBtn" class="col-2 mx-auto btn btn-info btn-block" data-target="rerollPopover">Reroll</button>
                </div>
            </div>

            <div id="randomRecipes" class="row">
                <?php
                    $database->query("SELECT Recipes.*, Users.userName FROM (Users INNER JOIN Recipes ON Users.userID = Recipes.chefID) ORDER BY RANDOM() DESC LIMIT 6;");
                    echo getRecipeCards($database, $database->results());
                    $database = null;
                ?>
            </div>
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
</body>
</html>
