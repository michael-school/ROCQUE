<?php 
    $title = "Shop";
    require "header.php";
?>


<main>
    <h1>Shop</h1>
    <?php 
    
        if (isset($_GET['error']) && $_GET['error'] == 'login') {
            echo "<p class='error'>Please Log In</p>";
        }
        if(isset($_SESSION['userId'])) {
            echo "<a id='cart-icon' href='customer/cart.php'><i class='fas fa-shopping-cart'></i></a>";
        }
    ?>

    <!-- Section -->
    <section class="container">
        <div class="row product-items" id="product-items">
            <?php //based off of database
                    require './includes/dbh.inc.php';
                    $sql = "SELECT primary_key as 'id', Products.NAME as 'name', price, description, image, in_stock as 'amount' FROM Products";
                    $result = $conn->query($sql);

                    function checkStock(int $amount, int $price) {
                        if ($amount == 0) {
                            return "Out of Stock";
                        } else {
                            return '$'.$price;
                        }
                    }

                    if ($result->num_rows > 0) {
                        // output data of each row
                        while($row = $result->fetch_assoc()) {

                            //message when stock of an item is low
                            $lowStockMessage = '';
                            if ($row['amount'] <= 5 && $row['amount'] != 0) {
                                $lowStockMessage = '<span class="card-body low-stock">Only '.$row['amount'].' left in stock!</span>';
                            }

                            // Basic Structure:
                            echo ' 
                                <div class="col-10 col-sm-6 col-lg-4 mx-auto my-3">
                                    <div class="card single-item shadow">
                                        <div class="img-container">
                                            <img src="img/products/'.$row["image"].'" class="card-img-top product-img" alt="">
                                            </div>
                                        <div class="card-body">
                                            <div class="card-text d-flex justify-content-between text-capitalize">
                                            <h5 id="item-name">'.$row["name"].'</h5>
                                            <span>'.checkStock($row['amount'], $row['price']) .'</span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-8">
                                                '.$lowStockMessage.'
                                            </div>
                                            <div class="col-4">
                                                <button style = "float: right;" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#shopModal" data-bs-product="'.ucwords($row['name']).'" data-bs-image="'.$row['image'].'" data-bs-description="'.$row['description'].'" data-bs-id="'.$row['id'].'" data-bs-max="'.$row['amount'].'" data-bs-price="'.checkStock($row['amount'], $row['price']).'">Order</button>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            ';
                        }
                    } else { echo "0 results"; }
                    $conn->close();
            ?>

        </div>
    </section>

    <!-- Modal that opens for each product -->
    <?php include "./includes/shopModal.php";?>

</main>


<?php require "footer.php";?>
