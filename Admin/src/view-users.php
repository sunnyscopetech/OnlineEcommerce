<?php
include 'config.php';

session_start();
$user_id = $_SESSION['userinfo'];
if (!isset($user_id)) {
    header('location:login.php');
    exit(); // Always exit after a header redirect
}

// Query to fetch all users from the `usertable`
$user_query = "SELECT * FROM `user` WHERE id != 1";

$result = mysqli_query($conn, $user_query);

// Check if query executed successfully
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Table</title>

    <link rel="stylesheet" href="view-order.css">
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

    <!-- Navbar section -->
    <header id="header">
        <a href="#" class="logo">Hariom Dresses</a>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="view-orders.php"><i class="fas fa-shopping-cart"></i>Orders</a></li>
            <li><a href="view-users.php" class="active"><i class=""></i>Users</a></li>
        </ul>
    </header>

    <h1>Users Tables</h1>
    <div class="container">
        <!-- User details table -->
        <table>
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Password</th>
                    <!-- Add more columns as per your `usertable` structure -->
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop through each user and display in table rows
                while ($user = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $user['id'] . "</td>";
                    echo "<td>" . $user['name'] . "</td>";
                    echo "<td>" . $user['email'] . "</td>";
                    echo "<td>" . $user['password'] . "</td>";
                    // Add more rows as per your `usertable` structure
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Footer Section -->
    <footer class="Footer">
        <div class="col">
            <a href="#" class="logo">Shopping</a>
            <h4>Contact</h4>
            <p><strong>Address:</strong> Hariom Dresses New Super Market Jamnagar:361001</p>
            <p><strong>Phone:</strong> +91 9377939952</p>
            <p><strong>Hours:</strong> 10:30am - 9:15pm, Mon - Sat</p>
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
        <p class="copyright">Made by <span>&copy; Sunny Meghrajani - 2024</span></p>
    </footer>
</body>
</html>

<?php
// Close database connection
mysqli_close($conn);
?>
