<?php 
    $title = "cart";
    require "../header.php";

    if (!isset($_SESSION['userId'])) {
        header("Location: $path/login.php");
        exit();
    }
?>

<main>
    <a href="<?php echo $path;?>/shop.php"><button id="contButt" class="btn btn-primary">Continue Shopping</button></a>
    <div class="row">
    <div class="col-md-6">
        <div class="card cart-card">
            <div class="table-responsive">
            <table class="table" id="cart">
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th></th>
                </tr>
                <!-- Fill in Table Data with php -->
                <?php
                    if(isset($_SESSION['cart'])){
                        $total = 0;
                        foreach ($_SESSION['cart'] as $k => $v) {
                            echo "<tr><td><img src='"."$path/img/products/".$v['image']."'><span class='text-nowrap'> ".ucwords($v['name'])."</span></td><td>".$v['quantity']."</td><td>$".$v['price']."</td><td>
                            <form method='post' action='".$path."/includes/cart.inc.php'>
                                <input type='hidden' name='action' value='remove'>
                                <input type='hidden' name='product' value='".$k."'>
                                <button id='trash' type='submit'><i class='fa fa-trash'-alt aria-hidden='true'></i></button>
                            </form></td></tr>";
                            $total += $v['price'] * $v['quantity'];
                        }
                    } else {
                        echo "<tr><td>CART EMPTY</td><td></td><td></td><td></td></tr>";
                    }
                ?>
            </table>
            </div>
        </div>
        <?php if (isset($total) && $total > 0) {echo '
            <div class="row">
                <div class="col px-0">
                    <form method="post" action="../includes/cart.inc.php">
                        <input type="hidden" name="action" value="empty">
                        <button type="submit" id="empty" class="btn btn-primary">Empty Cart</button>
                    </form>
                </div>
            </div>';}
        ?>
    </div>
    <!-- Total Price -->
    <div class="col-md-6">
        <div class="card total-card shadow">
            <div class="card-body row">
                <div class="col-md-6 card-text">
                    <p class="cart-fees">*Hey just so you know we're gonna add like a bunch of fees to this so it's actually gonna cost way more. And I mean WAY more. Like dude you are finna be in debt like you're back in college. The fees include: the Elijah Mitchel Patton fee, the Dwayne fee, the login fee, the lab fee, Christian's phone bill, Michael's water bill, Christian's Club Penguin membership, Shrey's Netflix account, the McDonald's we just ordered, the sus fee, the epic fee, the paperwork printing fee, the new clothes Shrey bought, stonks, sponsorships fee, the Samsung Family Hub 26.5-cu ft French Door Refrigerator with Ice Maker (Fingerprint Resistant Black Stainless Steel) ENERGY STAR fee, the 8K UHD surround sound 16 Gigs ram, HDR GEFORCE RTX, TI-80 texas insturments, Triple A duracell battery ultrapower100 Cargador Compatible iPhone 1A 5 W 1400 + Cable 100% 1 Metro Blanco Compatible iPhone 5 5 C 5S 6 SE 6S 7 8 X XR XS XS MAX GoPro hero 1 2 terrabyte xbox series x Dell UltraSharp 49 Curved Monitor - U4919DW Sony HDC-3300R 2/3" CCD HD Super Motion Color Camera fee, and many, MANY more.</p>
                </div>
                <div class="col-md-6">
                    <h1 class="cart-total">Total: $<?php echo (isset($total) && $total > 0) ? $total : '0';?></h1>
                    <?php if (isset($total) && $total > 0) {echo '
                    <a id="payment-btn" class="btn btn-primary" href="./payment.php">Proceed to Payment</a> ';}?>  
                </div>
            </div> 
        </div>
    </div>
</div>
                    
    
    
</main>
<!-- probably gonna have to randomly generate an order id to update two tables at once -->

<?php require "../footer.php";?>
