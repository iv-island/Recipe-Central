<?php
    require 'config.php';

    if(isset($_GET["recipeid"])){
        $database = new Database();
        $database->query("SELECT Recipes.*, Users.userName FROM (Users INNER JOIN Recipes ON Users.userID = Recipes.chefID AND recipeid=:recipeID);");
        $database->bind(':recipeID', $_GET['recipeid']);
        $recipeinfo = $database->results()[0];
    }
    else{
        http_response_code(404);
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
            <div class="row">
                <div class="col-12 text-center">
                    <h3><?php
                        if(isset($recipeinfo)){
                            echo $recipeinfo['recipename'];
                        }
                        else{
                            echo "Recipe";
                        }
                        ?></h3><hr/>
                </div>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <h5>Ingredients</h5>
                        <ul class="list-group">
                            <?php
                            if(isset($recipeinfo)){
                                $ingredientArray = json_decode(str_replace(['{', '}'], ['[', ']'], $recipeinfo['ingredients']));
                                for ($x = 0; $x < count($ingredientArray); $x++) {
                                    echo '<li class="list-group-item">' . $ingredientArray[$x] . '</li>';
                                }
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="cont">
                                    <div class="image-wrapper">
                                        <img alt="Recipe Image Preview" src="<?php if(isset($recipeinfo)) echo $recipeinfo['pictureurl'] ?>" class="img-fluid img-thumbnail">
                                        <button class="<?php if(isset($_SESSION['userid'])){echo "bookmark";} else{echo "login";} ?> btn btn-info btn-md" data-recipeid="<?php if(isset($recipeinfo)) echo $recipeinfo['recipeid'] ?>">
                                            <i class="<?php
                                            if(isset($_SESSION['userid']) && isset($recipeinfo)) {
                                                $database->query("SELECT * FROM bookmarks WHERE userid=" . $_SESSION['userid'] ." AND recipeid=" . $recipeinfo['recipeid'] . ";");
                                                $results = $database->results();
                                                $database = null;

                                                if (count($results) == 0) {echo "far";}
                                                else {echo "fas";}
                                            }
                                            else {echo "far";} ?> fa-bookmark"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <h5>Nutrition Facts</h5>
                                <p>Calories: <?php if(isset($recipeinfo)) echo ($recipeinfo['protein']*4 +$recipeinfo['carbs']*4 + $recipeinfo['fat']*9) ?></p>
                                <p>Protein: <?php if(isset($recipeinfo)) echo $recipeinfo['protein'] . 'g' ?></p>
                                <p>Carbs: <?php if(isset($recipeinfo)) echo $recipeinfo['carbs'] . 'g' ?></p>
                                <p>Fat: <?php if(isset($recipeinfo)) echo $recipeinfo['fat'] . 'g' ?></p>
                                <p>Sugars: <?php if(isset($recipeinfo)) echo $recipeinfo['sugars'] . 'g' ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <br><a class="text-muted" href="profile.php?userid=<?php if(isset($recipeinfo)) echo $recipeinfo['chefid']?>">Chef: <?php if(isset($recipeinfo)) echo $recipeinfo['username'] ?></a>
                                <br><i class="text-muted"><?php if(isset($recipeinfo)) echo $recipeinfo['foodtype'] ?></i>

                                <br><br>
                                <button id="dislike" class="btn btn-danger btn-md" data-chefid1="<?php if(isset($recipeinfo)) echo $recipeinfo['chefid'] ?>"><i class="far fa-thumbs-down"></i></button>
                                <button id="like" class="btn btn-success btn-md" data-chefid2="<?php if(isset($recipeinfo)) echo $recipeinfo['chefid'] ?>"><i class="far fa-thumbs-up"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
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
