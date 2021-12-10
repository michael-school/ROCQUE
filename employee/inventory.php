<!-- accessible to admin (role 1) and inventory manager (role 2)-->

<?php
    $title = "Inventory";
    require "../header.php";
?>

<?php 
    //check login status
    if (!isset($role) || ($role != 1 && $role != 2)) {
        header("Location: $path?login=failed");
        exit();
    }
?>


<main>
    <h1>Inventory</h1>
    <div class="table-responsive">
    <table class="table table-striped">
        <tr> <!-- table headers -->
            <th>Product</th>
            <th>Price</th>
            <th># in stock</th>
        </tr>
        
        <?php //table body based off of database
            require '../includes/dbh.inc.php';
            $sql = "SELECT primary_key as 'product_id', Products.NAME as 'products', price, in_stock as 'amount' FROM Products";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . ucfirst($row["products"]). "</td><td>" . $row["price"] . "</td><td>". $row["amount"]
                        .'<form action="../includes/updateinventory.inc.php" method="post"> 
                                <label for="new_amount">update to:</label>
                                <input type="hidden" name="product-id" value="'.$row["product_id"].'">
                                <input name="new-amount" id="new_amount" type="number" min="0" placeholder="'.$row["amount"].'">
                                <button type="submit" name="new-amount-submit" class="btn btn-primary">Submit</button>
                        </form>'
                        ."</td></tr>";
                }
                echo "</table>";
            } else { echo "0 results"; }
            $conn->close();
            
        ?>
    </table>
    </div>
</main>

<?php require "../footer.php";?>
