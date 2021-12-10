<?php 
    $title = "Order Info";
    require "../header.php";

    $exitpath = "$path/customer/myorders.php";

    if (!isset($_POST['order-info'])) {
        header("Location: $exitpath");
        exit();
    }

    require "../includes/dbh.inc.php";

    $order_id = $_POST['order-id'];

    $sql = "SELECT STATUS, address_1, address_2, city, state, zip FROM Orders WHERE primary_key=$order_id";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: $exitpath?error=sqlerror");
        exit();
    } else {
        $stmt->execute();
        $stmt->bind_result($status, $address_1, $address_2, $city, $state, $zip);

        //idk what this does or why it has to be in a while loop, but it finally fixed all my problems after multiple hours
        while ($stmt->fetch()) {
        
        }
    }

    $statusPercent = 0;
    switch ($status) {
        case 'PROCESSING':
            $statusPercent = 5;
            break;
        case 'IN TRANSIT':
            $statusPercent = 50;
            break;
        case 'DELIVERED':
            $statusPercent = 98;
            break;
    }
?>



<main class="order-info">

    
    <div class="card shadow mb-4 mx">
    <h1>Order ID: <?php echo $order_id; ?></h1>
        <div class="card-body p-5">
            <h4>Order Status</h4>
            <div class="row">
                <div class="col-4 text-start">
                    <p class="font-italic text-muted">Processing</p>
                </div>
                <div class="col-4 text-center">
                    <p class="font-italic text-muted">In Transit</p>
                </div>
                <div class="col-4 text-end">
                    <p class="font-italic text-muted">Delivered</p>
                </div>
            </div>
            <div style="height: 12px" class="progress rounded-pill">
                <div role="progressbar" aria-valuenow="<?php echo $statusPercent;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $statusPercent;?>%" class="progress-bar rounded-pill bg-gradient"></div>
            </div>
        </div>
        <hr>
        <div class="card-body px-5 py-2">
            <h4>Delivery Address</h4>
            <address>
                <?php echo "
                    $address_1<br>
                    $address_2<br>
                    $city, $state<br>
                    $zip
                "?>
            </address>
        </div>
        <hr>
        <div class="card-body p-5">
            <h4>Items</h4>
            <div class="table-responsive">
            <table class="table">
                <?php
                    $sql = "SELECT Products.NAME as 'product', image, quantity, description, price FROM Products JOIN Order_Items WHERE Order_Items.product_id = Products.primary_key and Order_Items.order_id = ".$order_id;
                    $result = $conn->query($sql);
                    while($row = $result->fetch_assoc()) {
                        echo "
                                <tr>
                                    <td>
                                        <img src='".$path."/img/products/".$row['image']."' height='30em'> ".$row['product']."
                                        <p>".$row['description']."<br>
                                        Qty: ".$row['quantity']."</p>
                                    </td>
                                    <td>".$row['price']."
                                    </td>
                                </tr>
                        ";
                    }
                ?>
            </table>
            </div>
        </div>
    </div>
</main>

<?php require "../footer.php";?>



