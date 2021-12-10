<?php
session_start();
//determines location for the header functions
$exitpath = 'https://datadev.devcatalyst.com/~mahs_BMDBTMBMM/shop.php';

if (isset($_POST['order-submit'])) {
    require 'dbh.inc.php';

    $address1 = $_POST['address-1'];
    $address2 = isset($_POST['address-2']) ? $_POST['address-2'] : NULL;
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $datetime = $_POST['datetime'];
    $status = 'PROCESSING';

    // generate order id
    $orderid = 0;
    do {
        $orderid = mt_rand(1000000000, 2147483647);

        $sql = "SELECT * FROM Orders WHERE primary_key = $orderid";
        $result = $conn->query($sql);
        $num_rows = $result->num_rows;

    } while ($num_rows != 0);


    //insert order into table with status of proccessing
    $sql = "INSERT INTO Orders (primary_key, user_id, DATETIME, address_1, address_2, city, state, zip, STATUS) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: $exitpath?error=sqlerror");
        exit();
    } else {

        mysqli_stmt_bind_param($stmt, "iisssssss", $orderid, $_SESSION['userId'], $datetime, $address1, $address2, $city, $state, $zip, $status);
        mysqli_stmt_execute($stmt);
        //insert order products into table
        foreach ($_SESSION['cart'] as $product => $product_array) {
            $productid = $product_array['id'];
            $quantity = $product_array['quantity'];
            $sql = "INSERT INTO Order_Items (order_id, product_id, quantity) VALUES ($orderid, $productid, $quantity)";

            if ($conn->query($sql) !== TRUE) {
                header("Location: $exitpath?error=sqlerror");
                exit();
            }

            //update inventory
            $sql = "SELECT * FROM Products WHERE primary_key=$productid";
            $result = $conn->query($sql);
            
            while ($row = $result->fetch_row()) {
                $quantityindex = 5; //for some reason the keys are not included in the row, so i have to use the numerical index
                $amount = $row[$quantityindex] - $quantity;
                $sql = "UPDATE Products SET in_stock=$amount WHERE primary_key=$productid";

                if ($conn->query($sql) !== TRUE) {
                    header("Location: $exitpath?error=sqlerror");
                    exit();
                }
                
            }
        }
        //empty cart 
        unset($_SESSION['cart']);

        $conn->close();
        header("Location: $exitpath?order=placed");
        exit();
    }

} else {
    header("Location: $exitpath");
    exit();
}