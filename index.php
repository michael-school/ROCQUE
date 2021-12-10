<?php 
    $title = "Home";
    require "header.php";
?>

<body>
    <main>
        <div id="carouselExampleCaptions" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="img/carousel/assorted_rocks.jpeg" class="d-block w-100 img-cropped" alt="...">
                        <div class="carousel-caption d-block">
                            <h1 class="brandname">ROCQUE</h1>
                            <p>The finest selection of rocks to ever grace humanity</p>
                            <a href="shop.php"><button type="button" class="btn-2">Shop Now</button></a>
                            <a data-bs-toggle="modal" href="#signupModal"><button type="button" class="btn-2">Sign Up</button></a>
                        </div>
                </div>
                <div class="carousel-item">
                    <img src="img/carousel/smooth_rocks.jpeg" class="d-block w-100 img-cropped" alt="...">
                    <div class="carousel-caption d-block">
                        <h1 class="brandname">ROCQUE</h1>
                        <p>These rocks are all around the galaxy, ranging from the moon to some guy's backyard</p>
                        <a href="shop.php"><button type="button" class="btn-2">Shop Now</button></a>
                        <a data-bs-toggle="modal" href="#signupModal"><button type="button" class="btn-2">Sign Up</button></a>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="img/carousel/pebble_rocks.jpeg" class="d-block w-100 img-cropped" alt="...">
                    <div class="carousel-caption d-block">
                        <h1 class="brandname">ROCQUE</h1>
                        <p>The rocks are quality tested by industry professionals to ensure the best product imaginable</p>
                        <a href="shop.php"><button type="button" class="btn-2">Shop Now</button></a>
                        <a data-bs-toggle="modal" href="#signupModal"><button type="button" class="btn-2">Sign Up</button></a>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <div class="services py-5 text-center bg-light">
          <div class="container">
              <div class="row">
                  <div class="col-10 mx-auto col-md-6 col-lg-4 my-3">
                      <span class="service-icon">
                          <i class="fas fa-shipping-fast"></i>                         
                      </span>
             <h5 class="font-weight-bold text-uppercase">Nationwide Shipping <br> with Numerous Fees</h5>
             <p>All of our customers can now enjoy insane shipping rates and no returns!</p>
                  </div>
                  <div class="col-10 mx-auto col-md-6 col-lg-4 my-3">
                    <span class="service-icon">
                        <i class="fas fa-microscope"></i>                           
                    </span>
           <h5 class="font-weight-bold text-uppercase">Certified by <a style="color: inherit; font-weight:bold;" href="https://www.instagram.com/eli.patton16/" target="_blank">Elijah Mitchel Patton</a> (Peace be upon him)</h5>
           <p>When we tell you our rocks are of the highest quality, we mean it</p>
                </div>
                <div class="col-10 mx-auto col-md-6 col-lg-4 my-3">
                    <span class="service-icon">
                        <i class="fas fa-money-check-alt"></i>                          
                    </span>
           <h5 class="font-weight-bold text-uppercase">0 Days Money Back Guaranteed</h5>
           <p>If you don't like our product, that's too bad! You can't return it and get a full refund!</p>
                </div>
              </div>
          </div>
        </div>

        <!-- Featured Products -->
        <h1>Featured Rocks</h1>
        <section class="container">
            <div class="row product-items align-items-center" id="product-items">
                <?php //based off of database
                        require './includes/dbh.inc.php';
                        $sql = "SELECT Products.primary_key as 'id', Products.NAME as 'name', price, description, image, in_stock as 'amount' FROM Products JOIN Featured_Products WHERE Featured_Products.product_id = Products.primary_key";
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
                                    <div class="col-10 col-sm-6 col-lg-4 mx-auto my-3 ">
                                        <div class="card single-item">
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
            <?php include "./includes/shopModal.php";?>
        </section>
        <!-- iFrame -->
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12283.171001360473!2d-122.33952605914423!3d47.60572214634561!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x54906ab6b122572d%3A0x4cc65f51348e1d43!2sDowntown%20Seattle%2C%20Seattle%2C%20WA!5e0!3m2!1sen!2sus!4v1636941696713!5m2!1sen!2sus" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>    </main>
</body>
<?php require "footer.php";?>
