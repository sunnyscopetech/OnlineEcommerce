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

// cart update and delete button
if (isset($_POST['Update_Cart']))
{
    $update_quantity = $_POST['cart_quantity'];
    $update_id= $_POST['cart_id'];
    mysqli_query($conn,"update cart set quantity='$update_quantity' where id='$update_id'") or die('query failed');
    $message[]='Cart Quantity Updated Successfully';
}
if (isset($_GET['remove']))
{
    $remove_id=$_GET['remove'];
    mysqli_query($conn,"delete from cart where id='$remove_id'") or die('query failed');
    header('location:cart-show.php');
    $message[]='Item Removed!';
}
if (isset($_GET['delete_all']))
{
    mysqli_query($conn,"delete from cart where user_id='$user_id'") or die('query failed');
    header('location:cart-show.php');
}
// cart update and delete button ends.....
?>


<link rel="stylesheet" href="./cart.css">

<!-- fontawesome cdn -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" 
                            crossorigin="anonymous" referrerpolicy="no-referrer" /></head>

        <!-- Pop-up Menu9 -->
        <?php
            if (isset($message)) {
                foreach ($message as $message) {
                    echo '<div class="message" onclick="this.remove();">' . $message . '</div>';
                }
            }
            ?>
   <body>  
    <!-- navbar section -->
        <header id="header">
            <a href="#" class="logo">Hariom Dresses</a>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="#">About</a></li>
                <li><a href="./cart-show.php" class="active"><i class="fas fa-shopping-cart">Cart</i></a></li>
            </ul>
        </header>

<!-- user_profile details -->
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

        <!-- table section -->
    <div class="shopping-cart">
    <div class="heading3">
        <h1 class="heading4">Shopping Cart</h1>
        <table>
            <thead>
            <thead>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Size</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Action</th>
            </thead>    

            <!-- display cart -->
        <?php
            $grand_total=0;
                $cart_query = mysqli_query($conn, "select * from cart where user_id='$user_id'") 
                or die('query failed');
                if (mysqli_num_rows($cart_query) > 0) {
                    while ($fetch_cart = mysqli_fetch_assoc($cart_query)) {
                        // Other existing columns remain unchanged
                        ?>
                        <tr>
                            <td><img src="images/<?php echo $fetch_cart['image']; ?>" height="180"></td>
                            <td><?php echo $fetch_cart['name']; ?></td>
                            <td><?php echo $fetch_cart['price']; ?>/-</td>
                            <td><?php echo $fetch_cart['size']; ?></td>
                            <td>
                                <form action="" method="post">
                                    <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
                                    <input type="number" min="1" name="cart_quantity" value="<?php echo $fetch_cart['quantity']; ?>">
                                    <input type="submit" name="Update_Cart" value="Update" class="option-btn">
                                </form>
                            </td>
                            <td>Rs:<?php echo number_format($fetch_cart['price'] * $fetch_cart['quantity']); ?>/-</td>
                            <td>
                                <a href="cart-show.php?remove=<?php echo $fetch_cart['id']; ?>" 
                                   class="delete-btn" onclick="return confirm('Remove item from Cart?');">Remove</a>
                            </td>
                        </tr>
                        <?php
                        $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
                    }                    
                };
            ?>
            <tr class="table-bottom">
                <td colspan="4" class="gt">Grand Total: </td>
                <td>Rs:<?php echo $grand_total?>/-</td>
                <td><a href="cart-show.php?delete_all" onclick="return confirm('Delete all from Cart?');" 
                class="delete-btn">Delete</a></td>
            </tr>
        </table>
        <div class="cart-btn">
            <a href="checkout.php" class="btn2 <?php echo ($grand_total > 1)?'':'disabled'; ?>">Proceed to Checkout</a>
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
        
    