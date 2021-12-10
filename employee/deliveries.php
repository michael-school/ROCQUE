<!-- accessible to admin (role 1) and delivery person (role 3)-->


<?php 
    $title = "Deliveries";
    require "../header.php";
?>

<?php 
    //check login status
    if (!isset($role) || ($role != 1 && $role != 3)) {
        header("Location: $path?login=failed");
        exit();
    }

    
    require '../includes/dbh.inc.php';


    //this is the table that will be copied for each accordion item
    function deliveriesTable(string $status) {
        $path = $GLOBALS['path'];
        require '../includes/dbh.inc.php';
        $sql = "SELECT Orders.primary_key as 'order_id', Orders.DATETIME as 'datetime', address_1, address_2, city, state, zip, Orders.STATUS as 'status', first_name, last_name FROM Orders JOIN Users WHERE Orders.user_id = Users.primary_key AND Orders.STATUS = '$status' ORDER BY Orders.DATETIME";
        $result = $conn->query($sql);
        echo mysqli_error($conn);
        if ($result->num_rows > 0) {
            //if the order is delivered, the table will have an additional column for delivery date
            $deliveryDateHeader = '';
            $showDeliveryDateContent = false;
            if ($status == "DELIVERED") {
                $deliveryDateHeader = '<th>Delivery Date</th>';
                $showDeliveryDateContent = true;
            }
            
            // output data of each row
            while($row = $result->fetch_assoc()) {
                echo "
                <div class='order table-responsive'>
                <table class='table table-striped'>
                    <tr>
                        <th>Order ID</th>
                        <th>Order Placed</th>
                        <th>Address</th>
                        <th>Status</th>
                        $deliveryDateHeader
                    </tr>
                <tr><td>" . $row["order_id"]. "</td><td>" . $row["datetime"]. "</td><td>". 
                $row['first_name']." ".$row['last_name']."<br>"
                .$row['address_1']."<br>"
                .$row['address_2']."<br>"
                .$row['city'].", ".$row['state']."<br>"
                .$row['zip']."<br>"
                . "</td><td>". $row["status"]."
                <form method='post' action='../includes/updateOrderStatus.inc.php'>
                    <input type='hidden' name='order' value='".$row['order_id']."'>
                    <input type='hidden' name='date' class='date-input'>
                    <label for'updateStatus'>Update Status To:</label>
                    <select id='updateStatus' name='updatedStatus'>
                        <option value='PROCESSING'>PROCESSING</option>
                        <option value='IN TRANSIT'>IN TRANSIT</option>
                        <option value='DELIVERED'>DELIVERED</option>
                    </select>
                    <button class='btn-primary' name='new-status-submit'>Update</button>
                </form>
                </td>";
                if ($showDeliveryDateContent) {
                    $sql3 = "SELECT delivery_date FROM Delivered_Orders WHERE order_id = ".$row['order_id'];
                    $result3 = $conn->query($sql3);
                    if ($result3->num_rows > 0) {
                        while($row3 = $result3->fetch_assoc()) {
                            echo "<td>".$row3['delivery_date']."</td>";
                        }
                    } else { echo "<td>0 results</td>";}
                }
                echo "</tr></table>";
                
                //table of products
                echo "
                    <button class='btn btn-primary' type='button' data-bs-toggle='collapse' data-bs-target='#a".$row['order_id']."-product-table' aria-expanded='false' aria-controls='a".$row['order_id']."-product-table'>
                        View Items
                    </button>
                    <div class='collapse' id='a".$row['order_id']."-product-table'>
                    <table class='table table-sm table-borderless mx-4'>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                        </tr>";

                $sql2 = "SELECT Products.NAME as 'product', Products.image as 'image', Order_Items.quantity as 'quantity' FROM Products JOIN Order_Items WHERE Order_Items.product_id = Products.primary_key and Order_Items.order_id = ".$row['order_id'];
                $result2 = $conn->query($sql2);
                while($row2 = $result2->fetch_assoc()) {
                    echo "
                            <tr>
                                <td>
                                    <img src='".$path."/img/products/".$row2['image']."' height='30em'> ".$row2['product']."
                                </td>
                                <td>".$row2['quantity']."</td>
                            </tr>
                        
                    ";
                }
                echo "</table></div>";
                echo "</div>"; //close <div class='order>
            }
        } else { echo "0 results"; }
            $conn->close();
    }
?>

<!-- Start the actual HTML -->
<main>
    <h1>Deliveries</h1>
    <div class="accordion" id="deliveryAccordion">
        <div class="accordion-item">
            <h2 class="accordion-header" id="newOrdersHeading">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#newOrders" aria-expanded="true" aria-controls="newOrders">
                New Orders
            </button>
            </h2>
            <div id="newOrders" class="accordion-collapse collapse show" aria-labelledby="newOrdersHeading" data-bs-parent="#deliveryAccordion">
            <div class="accordion-body">
                <?php deliveriesTable('PROCESSING');?>
            </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="transitOrdersHeading">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#transitOrders" aria-expanded="false" aria-controls="transitOrders">
                Orders in Transit
            </button>
            </h2>
            <div id="transitOrders" class="accordion-collapse collapse" aria-labelledby="transitOrdersHeading" data-bs-parent="#deliveryAccordion">
            <div class="accordion-body">
                <?php deliveriesTable('IN TRANSIT');?>
            </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="deliveredOrdersHeading">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#deliveredOrders" aria-expanded="false" aria-controls="deliveredOrders">
                Delivered Orders
            </button>
            </h2>
            <div id="deliveredOrders" class="accordion-collapse collapse" aria-labelledby="deliveredOrdersHeading" data-bs-parent="#deliveryAccordion">
            <div class="accordion-body">
                <?php deliveriesTable('DELIVERED');?>
            </div>
            </div>
        </div>
    </div>
</main>

<?php require "../footer.php";?>
<script src='../scripts/moment.js'></script>
<script src="../scripts/delivery.js"></script>
