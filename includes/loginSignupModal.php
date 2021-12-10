<?php 
if(!isset($title)){
    header("Location: ../index.php");
    exit();
}
?>
<div class="modal fade" id="loginModal" aria-hidden="true" aria-labelledby="loginModal" tabindex="-1">
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="loginModalLabel">Log In</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <section class="container">
            <div class="row" id="login-form">
                <?php //signup error messages
                    if (isset($_GET['error'])) {
                        switch ($_GET['error']) {
                            case 'emptyfields':
                                echo '<p class="error">fill in all fields</p>';
                                break;
                            case 'wrongpwd':
                                echo '<p class="error">Incorrect Password</p>';
                                break;
                            case 'nouser':
                                echo '<p class="error">No user exists with that email</p>';
                                break;
                        }
                    } else if (isset($_GET['signup']) && $_GET['signup'] == 'success') {
                        echo '<p class="success">Signup Success</p>';
                    }
                ?>
                <form action="<?php echo $path?>/includes/login.inc.php" method="post">
                    <input type="hidden" name="return" value="<?php echo $_SERVER['SCRIPT_NAME'];?>">
                    <input class="form-control" type="text" name="mail" placeholder="Enter Your Email Address">
                    <input class="form-control" type="password" name="pwd" placeholder="Enter Your Password">
                    <div class="center-align">
                        <button type="submit" name="login-submit" class="btn btn-primary center-align">Login</button>
                    </div>
                </form>
            </div>
        </section>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary" data-bs-target="#signupModal" data-bs-toggle="modal" data-bs-dismiss="modal">Sign Up</button>
    </div>
    </div>
</div>
</div>


<div class="modal fade" id="signupModal" aria-hidden="true" aria-labelledby="signupModalLabel" tabindex="-1">
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="signupModalLabel">Sign Up</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <section class="container">
            <div class="row" id="signup-form">
                <?php //signup error messages
                    if (isset($_GET['error'])) {
                        switch ($_GET['error']) {
                            case 'emptyfields':
                                echo '<p class="error">fill in all fields</p>';
                                break;
                            case 'terms':
                                echo '<p class="error">please agree to the terms and conditions</p>';
                                break;
                            case 'invalidmailname':
                                echo '<p class="error">invalid name and email</p>';
                                break;
                            case 'invalidmail':
                                echo '<p class="error">invalid email</p>';
                                break;
                            case 'invalidname':
                                echo '<p class="error">invalid name</p>
                                    <p class="notice">must only contain numbers and letters</p>';
                                break;
                            case 'invalidtel':
                                echo '<p class="error">invalid phone number</p>
                                    <p class="notice">must only contain numbers</p>';
                                break;
                            case 'passwordCheck':
                                echo '<p class="error">passwords must match</p>';
                                break;
                            case 'mailtaken':
                                echo '<p class="error">email taken</p>';
                                break;
                        }
                    }
                ?>
                <form action="<?php echo $path?>/includes/signup.inc.php" method="post">
                    <input type="hidden" name="return" value="<?php echo $_SERVER['SCRIPT_NAME'];?>">
                    <div class="row">
                        <div class="col">
                            <input class="form-control" type="text" name="firstName" placeholder="First Name" required>
                        </div>
                        <div class="col">
                            <input class="form-control" type="text" name="lastName" placeholder="Last Name" required>
                        </div>
                    </div>
                    <input class="form-control" type="email" name="mail" placeholder="Email" required>
                    <input class="form-control" type="tel" name="tel" placeholder="Phone Number" required>
                    <div class="row">
                        <div class="col">
                            <input class="form-control" type="password" name="pwd" placeholder="Password" required>
                        </div>
                        <div class="col">
                            <input class="form-control" type="password" name="pwd-repeat" placeholder="Confirm Password" required>
                        </div>
                    </div>
                    <div class="center-align">
                        <div class="form-check">
                            <input type="hidden" name="return" value="<?php echo $_SERVER['SCRIPT_NAME'];?>">
                            <input type="checkbox" id="terms" name="terms" value="checked">
                            <label for="terms">I agree to the <a href="<?php echo $path;?>/info/ROCQUE_terms_conditions.pdf" target="_blank">terms and conditions</a>.</label>
                        </div>
                        <button type="submit" name="signup-submit" class="btn btn-primary">Sign Up</button>
                    </div>
                </form>
            </div>
        </section>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary" data-bs-target="#loginModal" data-bs-toggle="modal" data-bs-dismiss="modal">Log In</button>
    </div>
    </div>
</div>
</div>


    
