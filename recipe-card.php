<?php
    function getRecipeCards($database, $rows, $showEdit = false){
        $response = "";

        if(isset($_SESSION['userid'])){
            $bookmark = "bookmark";
        }
        else{
            $bookmark = "login";
        }

        foreach ($rows as $row){
            $card =
            '<div class="col-sm-6 col-md-4 col-lg-3 col-xl-2 pt-5 pb-5 d-flex">
                <div class="card border-info" style="width: 25rem;">
                    <div class="embed-responsive embed-responsive-4by3 border">
                        <img alt="Recipe Image Preview" class="card-img-top embed-responsive-item" src="' . $row['pictureurl'] .'" />
                    </div>
                    <div class="card-img-overlay">
                        <button class="' . $bookmark . ' btn btn-info btn-md float-left" data-recipeid="' . $row['recipeid'] . '">    
                            <i class="';
                            // fas is filled in; far is outline
                            if(isset($_SESSION['userid'])) {
                                $database->query("SELECT * FROM bookmarks WHERE userid=" . $_SESSION['userid'] ." AND recipeid=" . $row['recipeid'] . ";");
                                $results = $database->results();

                                if (count($results) == 0) {
                                    $card = $card . "far";
                                }
                                else {
                                    $card = $card . "fas";
                                }
                            }
                            else {
                                $card = $card . 'far';
                            }

            $card .= ' fa-bookmark"></i>                                   
                        </button>';

                        if($showEdit == true) {
                            $database->query("SELECT * FROM recipes WHERE chefid=" . $_SESSION['userid'] ." AND recipeid=" . $row['recipeid'] . ";");
                            $results = $database->results();

                            if (count($results) == 1) {
                                $card.= '<form action="edit-recipe.php" method="get">
                                            <button class="btn btn-success btn-md float-right" name="recipeid" value="' . $row['recipeid'] . '"><i class="far fa-edit"></i></button>
                                         </form>';
                            }
                        }

                    $card .= '</div>
                    
                    <div class="card-body d-flex flex-column" style="transform: rotate(0);">
                        <div>
                            <form method="get" action="recipe.php">
                                <button value="'. $row['recipeid'] .'" name="recipeid" class="btn btn-block btn-link" style="color: black"> <span class="h5 card-title">' . $row['recipename'] . '</span></button>
                            </form>
                            <br><a class="card-subtitle text-muted" href="profile.php?userid='. $row['chefid'] . '" >Chef: ' . $row['username'] .'</a>
                            <br><i class="card-subtitle text-muted">' . $row['foodtype'] .'</i>
                        </div>
                        <hr/>
                        <h6 class="card-title">Ingredients</h6>
                        <div class="card-text">
                            <ul>';
                            $ingredientArray = json_decode(str_replace(['{', '}'], ['[', ']'], $row['ingredients']));
                            $size = count($ingredientArray);

                            // Limit the number of ingredients printed
                            if($size > 2){
                                $size = 2;
                            }
                            for ($x = 0; $x < $size; $x++) {
                                $card .= "<li>" . $ingredientArray[$x] . '</li>';
                            }
                            $card .= '</ul>
                        </div>
                        
                        <h6 class="card-title">Nutrition Facts</h6>
                        <div class="card-text">' .
                            '<ul><li>Protein: ' . $row['protein']  . 'g</li>' .
                            '<li>Carbs: ' . $row['carbs']  . 'g</li></ul>' .
                        '</div>
                        <div class="card-footer bg-transparent mt-auto">
                            <form method="get" action="recipe.php">
                                <button value="'. $row['recipeid'] .'" name="recipeid" class="btn btn-link card-link">View Full Recipe</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>';

            $response .= $card;
        }

        return $response;
    }
