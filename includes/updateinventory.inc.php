<?php

//determines location for the header functions
$exitpath = 'https://datadev.devcatalyst.com/~mahs_BMDBTMBMM/employee/inventory.php';

if (isset($_POST['new-amount-submit'])) {
    
    require 'dbh.inc.php';

    $amount = $_POST['new-amount'];
    $product = $_POST['product-id'];

    $sql = "UPDATE Products SET in_stock=$amount WHERE primary_key=$product";

    if ($conn->query($sql) === TRUE) {
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