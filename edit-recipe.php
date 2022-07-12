<?php
    require 'config.php';
    if(!isset($_SESSION['userid']) || empty($_SESSION['userid'])){
        http_response_code(401);
        die();
    }

    $database = new Database();
    $database->query("SELECT * FROM (Users INNER JOIN Recipes ON Users.userID = Recipes.chefID AND userid=". $_SESSION['userid'] .") WHERE recipeid=:recipeID;");
    $database->bind(':recipeID', $_GET['recipeid']);
    $recipeinfo = $database->results()[0];
    $database = null;
    if(!isset($recipeinfo) || empty($recipeinfo)){
        http_response_code(403);
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
                <h3>Edit Recipe</h3><hr/>
            </div>
        </div>
    </section>

    <!--  Recipe Edit  -->
    <section>
        <div class="container">
            <form method="post" action="request-handler.php" class="form">
                <div class="form-group ">
                    <h3>Recipe name: </h3>
                    <input type="text" name="recipename" class="form-control" value="<?php echo $recipeinfo['recipename'] ?>" required>
                </div>

                <div class="form-group">
                    <h3>Recipe type: </h3>
                    <select name="recipetype" class="custom-select">
                        <option value="Appetizers and Snacks" <?php if($recipeinfo['foodtype'] == "Appetizers and Snacks") echo "selected" ?>>Appetizers and Snacks</option>
                        <option value="Main Dishes" <?php if($recipeinfo['foodtype'] == "Main Dishes") echo "selected" ?>>Main Dishes</option>
                        <option value="World Cuisine" <?php if($recipeinfo['foodtype'] == "World Cuisine") echo "selected" ?>>World Cuisine</option>
                        <option value="Fruits and Vegetables" <?php if($recipeinfo['foodtype'] == "Fruits and Vegetables") echo "selected" ?>>Fruits and Vegetables</option>
                        <option value="Soups, Stews and Chili Recipes" <?php if($recipeinfo['foodtype'] == "Soups, Stews and Chili Recipes") echo "selected" ?>>Soups, Stews and Chili Recipes</option>
                        <option value="Side Dish" <?php if($recipeinfo['foodtype'] == "Side Dish") echo "selected" ?>>Side Dish</option>
                        <option value="Meat and Poultry" <?php if($recipeinfo['foodtype'] == "Meat and Poultry") echo "selected" ?>>Meat and Poultry</option>
                    </select>
                </div>

                <div class="form-group">
                    <h3>Image Link: </h3>
                    <input type="text" name="imagelink" class="form-control" value="<?php echo $recipeinfo['pictureurl'] ?>" required>
                </div>

                <div class="form-group">
                    <h3>Ingredients:</h3>
                    <textarea class="form-control" name="ingredients" rows="6" placeholder="Please insert a list separated by ," required><?php
                            $ingredientArray = json_decode(str_replace(['{', '}'], ['[', ']'], $recipeinfo['ingredients']));
                            $values = "";

                            for ($x = 0; $x < count($ingredientArray) - 1; $x++) {
                                $values .= trim($ingredientArray[$x]) . ', ';
                            }

                            $values .= trim($ingredientArray[count($ingredientArray)-1]);
                            echo $values;
                        ?></textarea>
                </div>

                <div class="form-group">
                    <h3>Protein: </h3>
                    <input type="text" name="protein" class="form-control" value="<?php echo $recipeinfo['protein'] ?>" required>
                </div>

                <div class="form-group">
                    <h3>Carbs: </h3>
                    <input type="text" name="carbs" class="form-control" value="<?php echo $recipeinfo['carbs'] ?>" required>
                </div>

                <div class="form-group">
                    <h3>Fat: </h3>
                    <input type="text" name="fat" class="form-control" value="<?php echo $recipeinfo['fat'] ?>" required>
                </div>

                <div class="form-group">
                    <h3>Sugars: </h3>
                    <input type="text" name="sugars" class="form-control" value="<?php echo $recipeinfo['sugars'] ?>" required>
                </div>

                <div class="form-group">
                    <button name="updateRecipe" class="btn btn-primary btn-block" value="<?php echo $recipeinfo['recipeid'] ?>">Update Recipe</button>
                </div>
            </form>

            <form action="request-handler.php" method="post">
                <div class="form-group">
                    <button name="deleteRecipe" class="btn btn-danger btn-block" value="<?php echo $recipeinfo['recipeid'] ?>">Delete Recipe</button>
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
