<?php
    require 'config.php';

    if(isset($_GET["userid"])){
        $database = new Database();
        $database->query("SELECT userName, email, rating FROM Users WHERE userid=:userid;");
        $database->bind(':userid', $_GET["userid"]);
        $userinfo = $database->results()[0];

        if(isset($userinfo)){
            $personalAccount = false;
            if($_SESSION['userid'] == $_GET["userid"]){
                $personalAccount = true;
            }
        }
        else{
            http_response_code(404);
            die();
        }
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

    <!--  User profile info  -->
    <section style="padding-top: 5rem; padding-bottom: 2rem;">
        <div class="container-fluid">
            <div class="text-center">
                <h1><?php echo $userinfo['username'] ?></h1>
                <h3>Rating: <?php echo $userinfo['rating'] ?></h3><br><br>

                <?php
                    if($personalAccount){
                        echo '<div class="row">
                                <button class="col-2 mx-auto btn btn-info btn-block" data-toggle="modal" data-target="#editProfileModal">Edit Profile</button>
                              </div>';
                    }
                ?>
            </div>
        </div>
    </section>

    <!-- User recipes -->
    <section class="bg-light" style="min-height: 67.5vh;">
        <div class="container-fluid">
            <div class="text-center">
                <h3><?php if($personalAccount) echo 'Your'; ?> Recipes</h3> <hr/>
            </div>

            <div class="row">
                <?php
                    $database->query("SELECT * FROM recipes WHERE chefid=:userid ORDER BY recipeID DESC;");
                    $database->bind(':userid', $_GET['userid']);
                    $results = $database->results();
                    $size = count($results);

                    if($size == 0){
                        if($personalAccount){
                            echo "<a class='h4 mx-auto' href='create-recipe.php'> Create your own recipe today! </a>";
                        }
                        else{
                            echo "<h4 class='mx-auto'>This user hasn't created any recipes yet</h4>";
                        }
                    }
                    else{
                        for ($x = 0; $x < $size; $x++) {
                            $results[$x]['username'] = $userinfo['username'];
                        }

                        echo getRecipeCards($database, $results, $personalAccount);
                    }

                    $database = null;
                ?>
            </div>
        </div>
    </section>

    <div class="modal" id="editProfileModal" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="editProfileLabel">Edit Profile</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card bg-light">
                        <article class="card-body mx-auto" style="max-width: 400px">
                            <form method="post" id="updateForm" action="request-handler.php" class="form">
                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-user"></i></span>
                                    </div>
                                    <input type="text" name="updateName" class="form-control" placeholder="Update Name">
                                </div>

                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-envelope"></i></span>
                                    </div>
                                    <input type="email" name="updateEmail" class="form-control" placeholder="Update Email">
                                </div>

                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-lock"></i></span>
                                    </div>
                                    <input type="password" id="newPassword" name="newPassword" class="form-control" placeholder="New Password">
                                </div>

                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-lock"></i></span>
                                    </div>
                                    <input type="password" id="confirmNewPassword" name="confirmNewPassword" class="form-control" placeholder="Repeat New Password">
                                </div>
                                <label id="updateErrLabel" class="text-danger"></label><br>
                                <div class="form-group">
                                    <input type="submit" id="updateBtn" name="updateProfile" class="btn btn-primary btn-block" value="Update Profile">
                                </div>
                            </form>
                            <form method="post" action="request-handler.php" class="form">
                                <div class="form-group">
                                    <input type="submit" name="deleteProfile" class="btn btn-danger btn-block" value="Delete Account">
                                </div>
                            </form>
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Back to top button -->
    <button type="button" class="btn btn-primary btn-floating btn-lg" id="btn-back-to-top">
        <i class="fas fa-arrow-up"></i>
    </button>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
    <script src="js/scroll-to-top.js"></script>
    <script src="js/ajax-requests.js"></script>

    <script>
        $('#updateForm').submit(function() {
            $('#updateErrLabel').empty();
            if($("#newPassword").val() != $("#confirmNewPassword").val()){
                $('#updateErrLabel').html("Passwords do not match");
                return false;
            }
            else{
                $('#updateBtn').addClass('disabled');
                return true;
            }
        });
    </script>
</body>
</html>
