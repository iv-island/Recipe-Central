<?php
    require 'config.php';

    if(!isset($_SESSION['userid']) || empty($_SESSION['userid'])){
        http_response_code(401);
        die();
    }
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

    <section style="padding-top: 5rem;">
        <div class="container-fluid">
            <div class="text-center">
                <h3>Create a New Recipe</h3><hr/>
            </div>
        </div>
    </section>

    <!-- Recipe form -->
    <section>
        <div class="container">
            <form method="post" action="request-handler.php" class="form">
                <div class="form-group">
                    <h3>Recipe name: </h3>
                    <input type="text" name="recipename" class="form-control" required>
                </div>

                <div class="form-group">
                    <h3>Recipe type: </h3>
                    <select name="recipetype" class="custom-select">
                        <option value="Appetizers and Snacks">Appetizers and Snacks</option>
                        <option value="Main Dishes">Main Dishes</option>
                        <option value="World Cuisine">World Cuisine</option>
                        <option value="Fruits and Vegetables">Fruits and Vegetables</option>
                        <option value="Soups, Stews and Chili Recipes">Soups, Stews and Chili Recipes</option>
                        <option value="Side Dish">Side Dish</option>
                        <option value="Meat and Poultry">Meat and Poultry</option>
                    </select>
                </div>

                <div class="form-group">
                    <h3>Image Link: </h3>
                    <input type="text" name="imagelink" class="form-control" required>
                </div>

                <div class="form-group">
                    <h3>Ingredients:</h3>
                    <textarea class="form-control" name="ingredients" rows="6" placeholder="Please insert a list separated by ," required></textarea>
                </div>

                <div class="form-group">
                    <h3>Protein: </h3>
                    <input type="text" name="protein" class="form-control" required>
                </div>

                <div class="form-group">
                    <h3>Carbs: </h3>
                    <input type="text" name="carbs" class="form-control" required>
                </div>

                <div class="form-group">
                    <h3>Fat: </h3>
                    <input type="text" name="fat" class="form-control" required>
                </div>

                <div class="form-group">
                    <h3>Sugars: </h3>
                    <input type="text" name="sugars" class="form-control" required>
                </div>

                <div class="form-group">
                    <input type="submit" name="createRecipe" class="btn btn-primary btn-block" value="Create Recipe">
                </div>
            </form>
        </div>
    </section>

    <!-- Back to top button -->
    <button type="button" class="btn btn-primary btn-floating btn-lg" id="btn-back-to-top">
        <i class="fas fa-arrow-up"></i>
    </button>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
    <script src="js/scroll-to-top.js"></script>
</body>
</html>
