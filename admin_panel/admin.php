<?php
session_start();
@include 'config.php';

if(isset($_POST['add_product'])){
   $p_name = $_POST['p_name'];
   $p_price = $_POST['p_price'];
   $p_image = $_FILES['p_image']['name'];
   $p_image_tmp_name = $_FILES['p_image']['tmp_name'];
   $p_image_folder = 'uploaded_img/'.$p_image;

   $insert_query = mysqli_query($conn, "INSERT INTO `product_data`(name, price, image) VALUES('$p_name', '$p_price', '$p_image')") or die('query failed');

   if($insert_query){
      move_uploaded_file($p_image_tmp_name, $p_image_folder);
      $message[] = 'product add succesfully';
   }else{
      $message[] = 'could not add the product';
   }
};

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_query = mysqli_query($conn, "DELETE FROM `product_data` WHERE product_id = $delete_id ") or die('query failed');
   if($delete_query){
      header('location:product_page.php');
      $message[] = 'product has been deleted';
   }else{
      header('location:product_page.php');
      $message[] = 'product could not be deleted';
   };
};

if(isset($_POST['update_product'])){
   $update_p_id = $_POST['update_p_id'];
   $update_p_name = $_POST['update_p_name'];
   $update_p_price = $_POST['update_p_price'];
   $update_p_image = $_FILES['update_p_image']['name'];
   $update_p_image_tmp_name = $_FILES['update_p_image']['tmp_name'];
   $update_p_image_folder = 'uploaded_img/'.$update_p_image;

   $update_query = mysqli_query($conn, "UPDATE `product_data` SET name = '$update_p_name', price = '$update_p_price', image = '$update_p_image' WHERE product_id = '$update_p_id'");

   if($update_query){
      move_uploaded_file($update_p_image_tmp_name, $update_p_image_folder);
      $message[] = 'product updated succesfully';
      header('location:product_page.php');
   }else{
      $message[] = 'product could not be updated';
      header('location:product_page.php');
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin panel</title>
   <link rel="icon" type="image/x-icon" href="image/logo1.png">
   <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"> -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php

if(isset($message)){
   foreach($message as $message){
      echo '<div class="message"><span>'.$message.'</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
   };
};

?>

<?php include 'header.php'; ?>
<div id="header">
        <h1><img src="image/logo.png" alt="Your Logo" id="logo">
        Products</h1>
    </div>
   <div class="sidebar"><center>
      <div class="logo-head">
                    <a href="user_dashboard.php"><img src="image/Profile.png" alt=""></a><p style="margin-left: 21px; color: black; margin-bottom: 50px;"><?php echo $_SESSION['name']; ?></p>
     </div></center>
      <li><a href="manager_dashboard.php"><img src="image/dashboard.png" style="width: 30px; display: inline-block; vertical-align: middle;">
                  <span style="display: inline-block; vertical-align: middle; margin-left: 10px;">Dashboard</span></a></li>
                <li><a href="Productsd.php" class="active">
                  <img src="image/gasul-product.png" style="width: 30px; display: inline-block; vertical-align: middle;">
                  <span style="display: inline-block; vertical-align: middle; margin-left: 10px;">Products</span>
                </a></li>
                <li><a href="orders.php"><img src="image/purchase.png" style="width: 30px; display: inline-block; vertical-align: middle;">
                  <span style="display: inline-block; vertical-align: middle; margin-left: 10px;">Purchase</span></a></li> <!-- Link to a page displaying order details -->
                <li><a href="sales.php"><img src="image/sale.png" style="width: 30px; display: inline-block; vertical-align: middle;">
                  <span style="display: inline-block; vertical-align: middle; margin-left: 10px;">Sales</span></a></li>
                 <li><a href="#sales"><img src="image/report.png" style="width: 30px; display: inline-block; vertical-align: middle;">
                  <span style="display: inline-block; vertical-align: middle; margin-left: 10px;">Reports</span></a></li>
                <li><a href="#sales"><img src="image/user-management.png" style="width: 30px; display: inline-block; vertical-align: middle;">
                  <span style="display: inline-block; vertical-align: middle; margin-left: 10px;">User Management</span></a></li><br><br>
                <li><a href="adminLogin.php">Logout</a></li> <!-- Link to log out of the application -->
    </div>
<div class="container">

<section>

<form action="" method="post" class="add-product-form" enctype="multipart/form-data">
   <h3>add a new product</h3>
   <input type="text" name="p_name" placeholder="enter the product name" class="box" required>
   <input type="number" name="p_price" min="0" placeholder="enter the product price" class="box" required>
   <input type="file" name="p_image" accept="image/png, image/jpg, image/jpeg" class="box" required>
   <input type="submit" value="add the product" name="add_product" class="btn">
</form>

</section>

<section class="display-product-table">

   <table>

      <thead>
         <th>product image</th>
         <th>product name</th>
         <th>product price</th>
         <th>action</th>
      </thead>

      <tbody>
         <?php
         
            $select_products = mysqli_query($conn, "SELECT * FROM `product_data`");
            if(mysqli_num_rows($select_products) > 0){
               while($row = mysqli_fetch_assoc($select_products)){
         ?>

         <tr>
            <td><img src="uploaded_img/<?php echo $row['image']; ?>" height="100" alt=""></td>
            <td><?php echo $row['name']; ?></td>
            <td>$<?php echo $row['price']; ?>/-</td>
            <td>
               <a href="product_page.php?delete=<?php echo $row['product_id']; ?>" class="delete-btn" onclick="return confirm('are your sure you want to delete this?');"> <i class="fas fa-trash"></i> delete </a>
               <a href="product_page.php?edit=<?php echo $row['product_id']; ?>" class="option-btn"> <i class="fas fa-edit"></i> update </a>
            </td>
         </tr>

         <?php
            };    
            }else{
               echo "<div class='empty'>no product added</div>";
            };
         ?>
      </tbody>
   </table>

</section>

<section class="edit-form-container">

   <?php
   
   if(isset($_GET['edit'])){
      $edit_id = $_GET['edit'];
      $edit_query = mysqli_query($conn, "SELECT * FROM `product_data` WHERE product_id = $edit_id");
      if(mysqli_num_rows($edit_query) > 0){
         while($fetch_edit = mysqli_fetch_assoc($edit_query)){
   ?>

   <form action="" method="post" enctype="multipart/form-data">
      <img src="uploaded_img/<?php echo $fetch_edit['image']; ?>" height="200" alt="">
      <input type="hidden" name="update_p_id" value="<?php echo $fetch_edit['id']; ?>">
      <input type="text" class="box" required name="update_p_name" value="<?php echo $fetch_edit['name']; ?>">
      <input type="number" min="0" class="box" required name="update_p_price" value="<?php echo $fetch_edit['price']; ?>">
      <input type="file" class="box" required name="update_p_image" accept="image/png, image/jpg, image/jpeg">
      <input type="submit" value="update the prodcut" name="update_product" class="btn">
      <input type="reset" value="cancel" id="close-edit" class="option-btn">
   </form>

   <?php
            };
         };
         echo "<script>document.querySelector('.edit-form-container').style.display = 'flex';</script>";
      };
   ?>

</section>

</div>
<script src="js/script.js"></script>

</body>
</html>