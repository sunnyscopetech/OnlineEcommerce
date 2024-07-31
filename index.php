<?php
include 'config.php';
session_start();
$user_id = $_SESSION['userinfo'];
if (!isset($user_id)) {
    header('location:login.php');
};

// Session destroy
if (isset($_GET['logout'])) {
    unset($user_id);
    session_destroy('');
    header('location:login.php');
}

// add to cart process
if(isset($_POST['add_to_cart'])) {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];
    $product_size = $_POST['product_size']; // New line to fetch size

    $select_cart = mysqli_query($conn,"select * from cart where name='$product_name' and user_id='$user_id'") or die('query failed');

    if(mysqli_num_rows($select_cart) > 0) {
        $message[] = 'Product already Exist!';
    } else {
        mysqli_query($conn,"insert into cart(user_id,name,price,image,quantity,size) 
        values('$user_id','$product_name','$product_price','$product_image','$product_quantity','$product_size')") or die('query failed');
        $message[] = 'Item Added';
    }
}
// add-to-cart process ends
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Shopping Page</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">

    <!-- fontawesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" 
    integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" 
    crossorigin="anonymous" referrerpolicy="no-referrer"/>
</head>

<body>

        <!-- navbar section -->
        <header id="header">
            <a href="#" class="logo">Hariom Dresses</a>
            <ul>
                <li><a href="index.php" class="active">Home</a></li>
                <li><a href="#">About</a></li>
                <li class="dropdown">
                <a href="#" class="dropdown-toggle">Category<i class="fas fa-caret-down"></i></a>
                <ul class="dropdown-menu">
                    <!-- Example dropdown items (replace with actual categories) -->
                    <li><a href="Categories/kurtis.php">Kurtis</a></li>
                    <li><a href="Categories/kurti-pair.php">Kurti Pair</a></li>
                    <li><a href="Categories/short-kurti.php">Short Kurtis</a></li>
                </ul>
                </li>
                <li><a href="cart-show.php"><i class="fas fa-shopping-cart">Cart</i></a></li>                     
            </ul>
        </header>


    <!-- Pop-up Menu9 -->
    <?php
    if (isset($message)) {
        foreach ($message as $message) {
            echo '<div class="message" onclick="this.remove();">' . $message . '</div>';
        }
    }
    ?>

    <!-- User-Profile Section -->
    <div class="container">
        <div class="user_profile">
            <?php
            $select_user = mysqli_query($conn, "select * from user where id='$user_id'")
                or die('query failed');
            if (mysqli_num_rows($select_user) > 0) {
                $fetch_user = mysqli_fetch_assoc($select_user);
            }
            ?>
            <p>Username:- <span><?php echo $fetch_user['name']; ?></span></p>
            <p>Email:- <span><?php echo $fetch_user['email']; ?></span></p>
            <div class="flex">
                <a href="login.php" class="btn">Login</a>
                <a href="register.php" class="option-btn">Register</a>
                <a href="login.php?logout=<?php echo $user_id; ?>" onclick="return confirm('are you sure?');" class="delete-btn">Logout</a>
            </div>
        </div>

        <!-- Displaying products -->
        <!-- <kurti Sections> -->
        <div class="products">
            <h1 class="heading">Products</h1>
            <div class="box-container">
                <?php
                $select_product = mysqli_query($conn, "select * from kurtis") or die('query failed');
                if (mysqli_num_rows($select_product) > 0) {
                    while ($fetch_product = mysqli_fetch_assoc($select_product)) {
                ?>
                        <form method="post" class="box" action="">
                            <img src="kurtis/<?php echo $fetch_product['image']; ?>">
                            <div class="name"><?php echo $fetch_product['name']; ?></div>
                            <div class="price">Rs:<?php echo $fetch_product['price']; ?>/-</div>
                            <input type="number" min="1" name="product_quantity" value="1"><br>
                            <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
                            <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
                            <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                            <label>Size:</label>
                            <label><input type="radio" name="product_size" value="M"> M</label>
                            <label><input type="radio" name="product_size" value="L"> L</label>
                            <label><input type="radio" name="product_size" value="XL"> XL</label>
                            <label><input type="radio" name="product_size" value="XXL"> XXL</label>
                            <input type="submit" value="Add To Cart" name="add_to_cart" class="btn1">
                        </form>
                <?php
                    };
                };
                ?>
            </div>
        </div>

                <!-- Banner -->
                <section id="banner" class="banner-margin">
                    <h4>Summer Collection</h4>
                    <h2>Best Summer Kurti's Collection</h2>
                </section>

        <!-- Displaying products -->
        <!-- Pair section -->
        <div class="products">
            <h1 class="heading2">Kurti Pair's</h1>
            <div class="box-container">
                <?php
                $select_product = mysqli_query($conn, "select * from kurti_pair") or die('query failed');
                if (mysqli_num_rows($select_product) > 0) {
                    while ($fetch_product = mysqli_fetch_assoc($select_product)) {
                ?>
                        <form method="post" class="box" action="">
                            <img src="kurti-pair/<?php echo $fetch_product['image']; ?>">
                            <div class="name"><?php echo $fetch_product['name']; ?></div>
                            <div class="price">Rs:<?php echo $fetch_product['price']; ?>/-</div>
                            <input type="number" min="1" name="product_quantity" value="1">
                            <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
                            <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
                            <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                            <label>Size:</label>
                            <label><input type="radio" name="product_size" value="M"> M</label>
                            <label><input type="radio" name="product_size" value="L"> L</label>
                            <label><input type="radio" name="product_size" value="XL"> XL</label>
                            <label><input type="radio" name="product_size" value="XXL"> XXL</label>
                            <input type="submit" value="Add To Cart" name="add_to_cart" class="btn1">
                        </form>
                <?php
                    };
                };
                ?>
            </div>
        </div>

                <!-- Banner -->
                <section id="banner2" class="banner-margin">
                    <h4>Summer Collection</h4>
                    <h2>Best Short Kurti's Collection</h2>
                </section>

        <!-- Displaying products -->
        <!-- Short Kurti section -->
        <div class="products">
            <h1 class="heading2">Short Kurti's</h1>
            <div class="box-container">
                <?php
                $select_product = mysqli_query($conn, "select * from short_kurti") or die('query failed');
                if (mysqli_num_rows($select_product) > 0) {
                    while ($fetch_product = mysqli_fetch_assoc($select_product)) {
                ?>
                        <form method="post" class="box" action="">
                            <img src="short-kurti/<?php echo $fetch_product['image']; ?>">
                            <div class="name"><?php echo $fetch_product['name']; ?></div>
                            <div class="price">Rs:<?php echo $fetch_product['price']; ?>/-</div>
                            <input type="number" min="1" name="product_quantity" value="1">
                            <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
                            <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
                            <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                            <label>Size:</label>
                            <label><input type="radio" name="product_size" value="M"> M</label>
                            <label><input type="radio" name="product_size" value="L"> L</label>
                            <label><input type="radio" name="product_size" value="XL"> XL</label>
                            <label><input type="radio" name="product_size" value="XXL"> XXL</label>
                            <input type="submit" value="Add To Cart" name="add_to_cart" class="btn1">
                        </form>
                <?php
                    };
                };
                ?>
            </div>
        </div>
    </div>

    <!-- Footer-Section -->
    <footer class="Footer">
        <div class="col">
        <a href="#" class="logo">Shopping</a>
        <h4>Contact</h4>
        <p><strong>Address:</strong>Hariom Dresses New Super Market jamnagar:361001</p>
        <p><strong>Phone:</strong>+91 9377939952</p>
        <p><strong>Hours:</strong>10:30am - 9:15pm,Mon - Sat</p>
        <div class="follow">
            <h4>Follow Us</h4>
            <div class="icon">
            <i class="fab fa-facebook-square"></i>
            <i class="fab fa-pinterest-square"></i>
            <i class="fab fa-instagram"></i>
            </div>
        </div>
        </div>
        <div class="col2">
            <h4>About</h4>
            <a href="#">About us</a>
            <a href="#">Delivery Information</a>
            <a href="#">Terms & Conditions</a>
            <a href="#">Contact us</a>
        </div>
        <div class="col3">
            <h4>My Account</h4>
            <a href="register.php">Sign In</a>
            <a href="cart_show.php">View Cart</a>
            <a href="#">My Wishlist</a>
            <a href="#">Help</a>
        </div>
        <div class="col-map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d58990.82777672383!2d70.00104522167969!3d22.4693873
            !2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39576abde44ce2c3%3A0xbd0207258520a3a2!2sHari%20om%20Dresses!
            5e0!3m2!1sen!2sin!4v1708442146160!5m2!1sen!2sin" 
            width="300" height="250"  allowfullscreen="" loading="fast" 
            referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <p class="copyright">Made by <span>&copy Sunny Meghrajani - 2024</span></p>
    </footer>
</body>

</html>