<?php

include 'config.php';

if(isset($_POST['submit'])){
    $name=$_REQUEST['name'];
    $email=$_REQUEST['email'];
    $pass=$_REQUEST['password'];
    

    $select =mysqli_query($conn, "SELECT * FROM user WHERE email='$email' AND password='$pass'")
    or die('query failed');

    if(mysqli_num_rows($select)>0)
    {
        $message[]='user already exist!';
    }
    else
    {
        mysqli_query($conn, "Insert into user(name,email,password,user_type) values('$name','$email','$pass','user')") 
        or die ('query failed 😒');
        $message[]='Registration Successfull';
        header('location:login.php');
    }
}
else{
    
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Register</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="./style.css">
        <!-- favicon icon -->
        <link rel="icon" type="image" href="./images/register-svg.png">
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
        <form action="register.php" method="post">
            <h2>Register Here...</h2>
            <label>Username</label>
            <input type="text" name="name" class="box" placeholder="username">
            <label>Email</label>
            <input type="email" name="email" class="box" placeholder="email">
            <label>Password</label>
            <input type="password" name="password" class="box" placeholder="password">
            <input type="submit" name="submit" class="btn">
            <p>Already have an account? <a href="login.php">Login Now</a></p>
        </form>
    </div> 
</body>
</html>