<?php
include 'config.php';
session_start();
$user_id = $_SESSION['userinfo'];
if (!isset($user_id)) {
    header('location:login.php');
    exit(); // Always exit after a header redirect
}

// Process form submission
if(isset($_POST['order_btn'])){
    $name = $_POST['name'];
    $number = $_POST['number'];
    $email = $_POST['email'];
    $method = $_POST['method'];
    $address = $_POST['address'];
    $landmark = $_POST['landmark'];
    $city = $_POST['city'];
    $pincode = $_POST['pincode'];

    // Fetch products from cart and calculate total price
    $cart_query = mysqli_query($conn, "SELECT * FROM cart WHERE user_id='$user_id'");
    $total_products = [];
    $price_total = 0;
    while ($product_item = mysqli_fetch_assoc($cart_query)) {
        $product_name = $product_item['name'] . ' (Size: ' . $product_item['size'] . ') x ' . $product_item['quantity'];
        $total_products[] = $product_name;
        $product_price = $product_item['price'] * $product_item['quantity'];
        $price_total += $product_price;
    }
    $total_product = implode(',', $total_products);

    // Insert order details into database
    $insert_query = "INSERT INTO `order` (name, number, email, method, address, landmark, city, pincode, total_products, total_price)
                    VALUES ('$name', '$number', '$email', '$method', '$address', '$landmark', '$city', '$pincode', '$total_product', '$price_total')";
    $detail_query = mysqli_query($conn, $insert_query);

    if ($detail_query) {
        // Display success message and order details
        echo "
        <div class='order-message-container'>
            <div class='message-container'>
                <h3>Thanks for Shopping😄!</h3>
                <div class='order-detail'>
                    <span class='products'><h2>Products Purchased: </h2>".$total_product."</span>
                    <span class='total'>Total: ".$price_total." </span>
                </div>
                <div class='customer-details'>
                    <p>Your name: <span>".$name."</span></p>
                    <p>Your number: <span>".$number."</span></p>
                    <p>Your email: <span>".$email."</span></p>
                    <p>Your address: <span>".$address.",".$landmark.",".$city.",".$pincode."</span></p>
                    <p>Your payment mode: <span>".$method."</span></p>
                </div>
                <a href='index.php' class='btnC'>Continue Shopping</a>
            </div>
        </div>";
    } else {
        echo "Error: " . mysqli_error($conn); // Display error message for debugging
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="checkout.css">
    <!-- fontawesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

    <!-- navbar section -->
    <header id="header">
        <a href="#" class="logo">Hariom Dresses</a>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="./cart-show.php"><i class="fas fa-shopping-cart"></i> Cart</a></li>
        </ul>
    </header>

    <div class="container">
        <h1 class="heading">Complete your order</h1>
        <section class="checkout-form">
            <form action="checkout.php" method="post"> <!-- Pointing to itself -->
            <div class="display-order">
                <?php
                $select_cart = mysqli_query($conn, "SELECT * FROM cart WHERE user_id='$user_id'");
                $total = 0;
                $grand_total = 0;
                if(mysqli_num_rows($select_cart) > 0){
                    while($fetch_cart = mysqli_fetch_assoc($select_cart)){
                        $total_price = number_format($fetch_cart['price'] * $fetch_cart['quantity']);
                        $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
                        ?>
                        <div class="product-details">
                            <span><?php echo $fetch_cart['name']; ?> (Size: <?php echo $fetch_cart['size']; ?>) x <?php echo $fetch_cart['quantity']; ?></span>
                            <span class="product-price">Rs: <?php echo $total_price; ?>/-</span>
                        </div>
                        <?php
                    }
                } else {
                    echo "<div class='display-order'><span>Your cart is Empty</span></div>";
                }
                ?>
                <span class="grand-total">Grand total: Rs <?php echo $grand_total; ?>/-</span>
            </div>

                <div class="flex">
                    <div class="inputbox">
                        <span>Your Name</span>
                        <input type="text" placeholder="Your name here" name="name" required>
                    </div>
                    <div class="inputbox">
                        <span>Your Number</span>
                        <input type="text" placeholder="Your number here" name="number" required>
                    </div>
                    <div class="inputbox">
                        <span>Your Email</span>
                        <input type="email" placeholder="Your email here" name="email" required>
                    </div>
                    <div class="inputbox">
                        <span>Payment Method</span>
                        <select name="method">
                            <option value="cash on delivery" selected>Cash on Delivery</option>
                            <option value="credit card">Credit / Debit</option>
                            <option value="paypal">Paypal</option>
                        </select>
                    </div>
                    <div class="inputbox">
                        <span>Your Address</span>
                        <input type="text" placeholder="Your address here" name="address" required>
                    </div>
                    <div class="inputbox">
                        <span>Landmark</span>
                        <input type="text" placeholder="Your landmark" name="landmark" required>
                    </div>
                    <div class="inputbox">
                        <span>Your City</span>
                        <input type="text" placeholder="Your city here" name="city" required>
                    </div>
                    <div class="inputbox">
                        <span>Pincode</span>
                        <input type="number" placeholder="Your pincode here" name="pincode" required>
                    </div>
                </div>
                <input type="submit" value="Order Now" name="order_btn" class="cart-btn">
            </form>
        </section>
    </div>
</body>
</html>
