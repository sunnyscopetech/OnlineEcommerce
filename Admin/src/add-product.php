<?php
include 'config.php';
session_start();

// inserting products
if(isset($_POST['add_product'])){
    $p_name=$_POST['p_name'];
    $p_price=$_POST['p_price'];
    $p_image=$_FILES['p_image']['name'];
    $p_image_tmp_name=$_FILES['p_image']['tmp_name'];
    $p_image_folder='uploadimages/'.$p_image;

    $insert_query=mysqli_query($conn, "Insert into kurtis(name,price,image) values('$p_name','$p_price','$p_image')")
    or die('query failed');
    if($insert_query)
    {
        move_uploaded_file($p_image_tmp_name,$p_image_folder);
        $message[]="Product inserted Successfully!";
        // header('location:./admin.php');
    }else{
        $message[]='Product cant be added!'; 
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="add kurtis.css">
    <!-- <link rel="stylesheet" href="./admin.css"> -->
        <!-- fontawesome cdn -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" 
              integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" 
              crossorigin="anonymous" referrerpolicy="no-referrer" /></head>

</head>
<body>
    <div class="container" style="margin-top: 40px;">

    <?php          
        if(isset($message))
        {
            foreach($message as $message)
            {
                echo '<div class="message" onclick="this.remove();">'.$message.'</div>';
            }
        } 
    ?>

            <!-- Adding products -->
        <section>
        <form action="add-Product.php" method="post" class="add-product" enctype="multipart/form-data">
            <h3>Add a Kurti</h3>
            <input type="text" name="p_name" placeholder="Enter name of Product" class="box" required>
            <input type="text" name="p_price" placeholder="Enter price of Product" class="box" required>
            <input type="file" name="p_image" accept="image/png,image/jpg,image/jpeg" class="box" required>
            <input type="submit" value="add product" name="add_product" class="btnk">
        </form>
        <div class="row">
        <a href="index.php"><input type="submit" value="Back to Home" class="btn1"></a>
        </div>
        </section>
</body>
</html>
