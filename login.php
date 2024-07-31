<?php

include 'config.php';
session_start();
    if(isset($_POST['submit'])){
    
    $email=$_REQUEST['email'];
    $pass=$_REQUEST['password'];

    $select =mysqli_query($conn, "SELECT * FROM user WHERE email='$email' AND password='$pass'")
    or die('query failed');

    if(mysqli_num_rows($select)>0)
    {
        $row=mysqli_fetch_array($select);
        if($row['user_type']=='admin'){
            $_SESSION['userinfo']=$row['id'];
            header('location:./Admin/index.php');
        }elseif($row['user_type']=='user'){
            $_SESSION["userinfo"] = $row['id'];
            header('location:./index.php');
        }
    }else{
        $message[]='incorrect email or password!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>login</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="./style.css">
        
        <!-- favicon icon -->
        <link rel="icon" type="image" href="./images/login-svg.png">

    </head>
    <body>

        <?php
        if(isset($message))
        {
            foreach($message as $message)
            {
                echo '<div class="message" onclick="this.remove();">'.$message.'</div>';
            }
        }
        ?>
        
    <div class="form-container">
        <form action="" method="post">
            <h2>Login Here...</h2>
            <label>Email</label>
            <input type="email" name="email" class="box" placeholder="email">
            <label>Password</label>
            <input type="password" name="password" class="box" placeholder="password">
            <input type="submit" name="submit" class="btn" value="login now">
            <p>Don't have an account? <a href="register.php">Register Now</a></p>
        </form>
    </div> 
</body>
</html>
