<?php 
    $title = "My Orders";
    require "../header.php";

    if (!isset($_SESSION['userId'])) {
        header("Location: $path?login=failed");
        exit();
    }
?>

<!-- This page is only available to people who are logged in and changes based off of who is logged in -->
<main>
    <h1>Orders</h1>
        
        <?php //table body based off of database
            require '../includes/dbh.inc.php';
            $sql = "SELECT primary_key as 'order_id', DATETIME, STATUS FROM Orders WHERE user_id = ".$_SESSION['userId']." ORDER BY DATETIME DESC";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "
                    <div class='order table-responsive'>
                    <table class='table table-striped'>
                        <tr>
                            <th>Order Number</th>
                            <th>Order Placed</th>
                            <th>Status</th>
                        </tr>
                    <tr><td>" . ucfirst($row["order_id"]). "</td><td>" . $row["DATETIME"] . "</td><td>". $row["STATUS"]."</td></tr></table>";
                    
                    //table of products
                    echo "
                        <button class='btn btn-primary viewItems-button' type='button' data-bs-toggle='collapse' data-bs-target='#a".$row['order_id']."-product-table' aria-expanded='false' aria-controls='a".$row['order_id']."-product-table'>
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
                    echo "</table></div>
                        <form method='post' action='orderinfo.php'>
                                <input type='hidden' name='order-id' value='".$row["order_id"]."'>
                                <button class='btn btn-primary moreInfo-button' type='submit' name='order-info'>More Info</button>
                        </form>";
                    echo "</div>"; //close <div class='order>
                }
            } else { echo "<p>You have no orders</p><a href='$path/shop.php'><button type='button' class='btn-2'>Shop Now</button></a>"; }
            $conn->close();
            
        ?>
    </table>
</main>

<?php require "../footer.php";?>



