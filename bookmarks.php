<?php
require 'config.php';

if(!isset($_SESSION['userid']) || empty($_SESSION['userid'])){
    http_response_code(401);
    die();
}

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

    <!--  Bookmarked Recipes  -->
    <section style="padding-top: 5rem; padding-bottom: 2rem;">
        <div class="container-fluid">
            <div class="text-center">
                <h3>Bookmarked Recipes</h3> <hr/>
            </div>

            <div class="row">
                <?php
                    $database->query("SELECT Recipes.*, Users.userName FROM (Users INNER JOIN (SELECT Recipes.* FROM (Bookmarks INNER JOIN Recipes ON Bookmarks.recipeID = Recipes.recipeID) WHERE userID = :userID) AS Recipes ON Users.userid = Recipes.chefID) ORDER BY recipeID DESC;");
                    $database->bind(':userID', $_SESSION['userid']);
                    $results = $database->results();

                    if(count($results) == 0){
                        echo "<a class='h4 mx-auto' href='advanced-search.php'> Start finding new favorite recipes today! </a>";
                    }
                    else{
                        echo getRecipeCards($database, $results);
                    }

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
