<?php 
if(!isset($title)){
    header("Location: ../index.php");
    exit();
}
?>
<section>
    <div class="modal fade" id="shopModal" tabindex="-1" aria-labelledby="shopModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shopModalLabel">New message</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                <div class="row">
                    <div class="col-6">
                        <img>
                    </div>
                    <div class="col-6">
                        <p></p>
                    </div>
                </div>
                </div>
            </div>
            <div class="modal-footer">
                <p></p>
                <form method="post" action="./includes/cart.inc.php">
                    <input type="hidden" name="product-id">
                    <input type="hidden" name="action" value="add">
                    <input type="number" value="1" min="1" name="quantity">
                    <?php if (isset($_SESSION['userId'])) {echo '<button type="submit" class="btn btn-primary">Add to Cart</button>';}
                    else {echo '<a class="btn btn-primary" data-bs-dismiss="modal" data-bs-target="#loginModal" data-bs-toggle="modal" role="button">Login to Add to Cart</a>';}?>
                    
                </form>
            </div>
        </div>
    </div>
    </div>
</section>

<script src="scripts/shop_modal.js"></script>