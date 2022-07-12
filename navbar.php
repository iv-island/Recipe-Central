<?php
    function getNav(){
        $nav = '<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
                <div class="container-fluid">
                    <a class="navbar-brand" href="index.php">Recipe Central</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                        <span class="navbar-toggler-icon"></span>
                    </button>
            
                    <div class="collapse navbar-collapse" id="collapsibleNavbar">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="advanced-search.php"> Advanced Search </a>
                            </li>
                        ';

        $login = '<ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-toggle="modal" data-target="#signUpModal" role="button"><span class="fas fa-user-plus"></span> Sign Up </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="modal" data-target="#logInModal" role="button"><span class="fas fa-sign-in-alt"></span> Login </a>
                </li>
                
            </ul>';

        $logout = '<li class="nav-item">
                <form method = "post" action="request-handler.php">
                    <button type="submit" name="signout" class="btn-own"><span class="fas fa-sign-out-alt"></span> Logout </button>
                </form>
            </li>';

        if(isset($_SESSION['username'])) {
            $nav = $nav . "
                            <li class='nav-item'> 
                                <a class='nav-link' href='create-recipe.php'> Create Recipe </a> 
                            </li> 
                            <li class='nav-item'> 
                                <a class='nav-link' href='bookmarks.php'> Bookmarks </a> 
                            </li></ul>
                            <ul class='navbar-nav ml-auto'> 
                            
                            <li class='nav-item'> 
                                <a class='nav-link' href='profile.php?userid=" . $_SESSION['userid'] . "'> " . $_SESSION['username'] . "</a> 
                            </li>"
                . $logout .
                "</ul>";
        }
        else {
            $nav = $nav . "<li class='nav-item'> 
                                <a class='nav-link' data-toggle='modal' data-target='#logInModal' role='button'> Create Recipe </a> 
                            </li> 
                            <li class='nav-item'> 
                                <a class='nav-link' data-toggle='modal' data-target='#logInModal' role='button'> Bookmarks </a> 
                            </li></ul>" . $login;
        }
        $nav = $nav . "</div></div></nav>";

        $signUpModal = '<div class="modal" id="signUpModal" tabindex="-1" aria-labelledby="signUpModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="signUpModalLabel">Create an Account</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
    
                    <div class="modal-body">
                        <div class="card bg-light">
                            <article class="card-body mx-auto" style="max-width: 400px;">
                                <form id="signUpForm" class="form"
                                    oninput=\'confirmPassword.setCustomValidity(confirmPassword.value != password.value ? "Passwords do not match" : "")\'>
                                    <div class="form-group input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                        </div>
                                        <input type="text" name="fullName" class="form-control" id="fullName" placeholder="Full name" required>
                                    </div>
        
                                    <div class="form-group input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                                        </div>
                                        <input type="email" name="email" class="form-control" id="emailSignUp" placeholder="Email address" required>
                                    </div>
        
                                    <div class="form-group input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                        </div>
                                        <input type="password" name="password" class="form-control" id="password1" placeholder="Enter password" required>
                                    </div>
        
                                    <div class="form-group input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                        </div>
                                        <input type="password" class="form-control" name="confirmPassword" id="password2" placeholder="Repeat password" required>
                                    </div>
                                    <label class="text-danger" id="signUpErrLabel"></label><br>
                                    <div class="form-group">
                                        <input id="signUpBtn" type="submit" class="btn btn-primary btn-block">
                                    </div>
                                    <p class="text-center">Already have an account? <a role="button" class="text-primary" data-toggle="modal" data-target="#logInModal" data-dismiss="modal">Log In</a></p>
                                </form>
                            </article>
                        </div>
                    </div>
                </div>
            </div>
        </div>';

        $logInModal = '<div class="modal" id="logInModal" tabindex="-1" aria-labelledby="logInModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="logInModalLabel">Log In</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <div class="modal-body">
                        <div class="card bg-light">
                            <article class="card-body mx-auto" style="max-width: 400px;">
                                <form id="logInForm" class="form">
                                    <div class="form-group input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                                        </div>
                                        <input type="email" name="email" class="form-control" id="email" placeholder="Enter email" required>
                                    </div>
    
                                    <div class="form-group input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                        </div>
                                        <input type="password" name="password" class="form-control" id="login-password" placeholder="Password" required>
                                    </div>
                                    <label class="text-danger" id="logInErrLabel"></label><br>
                                    <div class="form-group">
                                        <input type="submit" id="logInBtn" class="btn btn-primary btn-block">
                                    </div>
                                    <p class="text-center">Don\'t have an account? <a role="button" class="text-primary" data-toggle="modal" data-target="#signUpModal" data-dismiss="modal">Sign up</a> </p>
                                </form>
                            </article>
                        </div>
                    </div>
                </div>
            </div>
        </div>';

        return $nav . $signUpModal . $logInModal;
    }
