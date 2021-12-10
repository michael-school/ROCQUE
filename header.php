<?php 
    if (session_status() === PHP_SESSION_NONE){
        session_start();
    }
    

    //echo for absolute file paths
    $path = 'https://datadev.devcatalyst.com/~mahs_BMDBTMBMM';
    //set role variable => admin: 1, inventory: 2, delivery: 3, regular customer: 0
    $role = isset($_SESSION['userRole']) ? $_SESSION['userRole'] : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?php echo $path;?>/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="<?php echo $path?>/styles.css">
        <title>ROCQUE | <?php echo $title; ?></title>
    <script src="https://kit.fontawesome.com/332a215f17.js" crossorigin="anonymous"></script>
</head>
<body>

    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light stroke">
            <a class="navbar-brand brandname" href="<?php echo $path?>">ROCQUE</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-content" aria-controls="navbar-content" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse px-2" id="navbar-content">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $path?>/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $path?>/shop.php">Shop</a>
                    </li>
                    <li class="nav-item" <?php if(!isset($_SESSION['userId'])){echo 'style="display: none;"';}?>>
                        <a class="nav-link" href="<?php echo $path?>/customer/myorders.php">My Orders</a>
                    </li>
                    <li class="nav-item" <?php if($role != 1 && $role !=3){echo 'style="display: none;"';}?>>
                        <a class="nav-link" href="<?php echo $path?>/employee/deliveries.php">Deliveries</a>
                    </li>
                    <li class="nav-item" <?php if($role != 1 && $role !=2){echo 'style="display: none;"';}?>>
                        <a class="nav-link" href="<?php echo $path?>/employee/inventory.php">Inventory</a>
                    </li>
                    <li class="nav-item" <?php if($role != 1){echo 'style="display: none;"';}?>>
                        <a class="nav-link" href="<?php echo $path?>/employee/employees.php">Employees</a>
                    </li>
                    <!-- <li>
                        <div class="input-group">
                                        <div class="form-outline">
                                            <input id="search-focus" type="search" id="form1" class="form-control" />
                                            <label class="form-label" for="form1">Search</label>
                                        </div>
                                        <button type="button" class="btn btn-primary">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                    </li> -->
                    <?php
                        //both options close the <ul> and <nav>
                        if (isset($_SESSION['userId'])) { // shows name and logout button when signed in
                            echo '
                                </ul>
                                <span class="navbar-text">'.$_SESSION['userFirstName'].'</span>
                                <form action="'.$path.'/includes/logout.inc.php" method="post">
                                    <button type="submit" name="logout-submit" class="btn btn-primary">Logout</button>
                                </form>
                                </nav>
                            ';
                        } else { // shows login and signup buttons when signed out
                            echo '</ul>
                            <a class="btn btn-primary" data-bs-toggle="modal" href="#loginModal" role="button">Login</a>
                            </nav>';
                            include "./includes/loginSignupModal.php";
                        }
                    ?>
            </div>
            
        </nav>
    </header>
