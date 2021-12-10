<?php
//check if logged in and check action varable, clear action varable afterward

//determines location for the header functions
$exitpath = 'https://datadev.devcatalyst.com/~mahs_BMDBTMBMM/shop.php';
$exitToCart = 'https://datadev.devcatalyst.com/~mahs_BMDBTMBMM/customer/cart.php';

session_start();

if (isset($_SESSION['userId'])) {
    //what is the user trying to do?
    $action = $_POST['action'];
    $cart =& $_SESSION['cart'];

    switch ($action) {
        case 'add':
            require 'dbh.inc.php';

            $productId = $_POST['product-id'];
            $quantity = $_POST['quantity'];
            settype($quantity, "integer");
    
            // add an item to cart
            $sql = "SELECT Products.NAME as 'product', image, price FROM Products WHERE primary_key=$productId";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: $exitpath?error=sqlerror");
                exit();
            } else {
                $stmt->execute();
                $stmt->bind_result($product, $image, $price);

                //idk what this does or why it has to be in a while loop, but it finally fixed all my problems after multiple hours
                while ($stmt->fetch()) {
                
                }

                
                //check if item is already in cart
                if(!empty($cart[$product])){
                    $cart[$product]['quantity'] += $quantity;
                } else {
                    $cart[$product] = [
                        'id' => $productId,
                        'name' => $product,
                        'image' => $image,
                        'price' => $price,
                        'quantity' => $quantity
                    ];
                }
            }
            $conn->close();
            unset($_POST['action']);
            header("Location: $exitpath?cartupdated=1");
            exit();
            break;
        case 'remove':
            // remove an item from cart
            $product = $_POST['product'];

            unset($cart[$product]);

            unset($_POST['action']);
            header("Location: $exitToCart");
            exit();
            break;
        case 'empty':
            //empty the entire cart
            unset($_SESSION['cart']);

            unset($_POST['action']);
            header("Location: $exitToCart");
            exit();
            break;
        default:
        //error message
        header("Location: $exitpath?error=noaction");
        exit();
    }
} else {
    header("Location: $exitpath?error=login");
    exit();
}