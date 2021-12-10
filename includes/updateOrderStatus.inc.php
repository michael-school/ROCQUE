<?php

//determines location for the header functions
$exitpath = 'https://datadev.devcatalyst.com/~mahs_BMDBTMBMM/employee/deliveries.php';

if (isset($_POST['new-status-submit'])) {
    
    require 'dbh.inc.php';

    $order = $_POST['order'];
    $status = $_POST['updatedStatus'];
    $date = $_POST['date'];

    $sql = "UPDATE Orders SET STATUS='$status' WHERE primary_key=$order";

    if ($conn->query($sql) === TRUE) {
        if ($status == 'DELIVERED') {
            $sql = "INSERT INTO Delivered_Orders (order_id, delivery_date) VALUES ($order, '$date')";
            if ($conn->query($sql) !== TRUE) {
                header("Location: $exitpath?error=sqlerror");
                exit();
            }
        } 
        header("Location: $exitpath?update=success");
        exit();
    } else {
        header("Location: $exitpath?error=sqlerror");
        exit();
    }

    

    $conn->close();


} else {
    header("Location: $exitpath");
    exit();
}