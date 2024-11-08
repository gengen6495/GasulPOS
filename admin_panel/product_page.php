<?php
session_start();
include 'config.php';

if(isset($_POST['add_product'])){
   $p_name = $_POST['p_name'];
   $p_price = $_POST['p_price'];
   $p_stock = $_POST['p_stock'];
   $p_image = $_FILES['p_image']['name'];
   $p_image_tmp_name = $_FILES['p_image']['tmp_name'];
   $p_image_folder = 'uploaded_img/'.$p_image;

   $insert_query = mysqli_query($conn, "INSERT INTO `product_data`(product_name, product_price, product_stocks, product_image) VALUES('$p_name', '$p_price', '$p_stock', '$p_image')") or die('query failed');

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
   $update_p_stock = $_POST['update_p_stock'];
   $update_p_image = $_FILES['update_p_image']['name'];
   $update_p_image_tmp_name = $_FILES['update_p_image']['tmp_name'];
   $update_p_image_folder = 'uploaded_img/'.$update_p_image;

   $update_query = mysqli_query($conn, "UPDATE `product_data` SET product_name = '$update_p_name', product_price = '$update_p_price',  product_stocks = '$update_p_stock', product_image = '$update_p_image' WHERE product_id = '$update_p_id'");

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
   <title>Manager dashboard - Product_Page</title>
   <link rel="icon" type="image/x-icon" href="image/logo1.png">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">

   <style>

:root{
   --orange: #c54029;
   --grid-row-end: :#10516e;
   --black:#333;
   --white:#fff;
   --bg-color:#eee;
   --dark-bg:rgba(0,0,0,.7);
   --box-shadow:0 .5rem 1rem rgba(0,0,0,.1);
   --border:.1rem solid #999;
}
body {
   margin: 0;
   padding: 0;
   background: linear-gradient(90deg, hsla(9, 58%, 47%, 1) 0%, hsla(215, 76%, 41%, 1) 100%);
}
*{
   font-family: 'Poppins', sans-serif;
   box-sizing: border-box;
   outline: none; 
   border:none;
   text-decoration: none;
   text-transform: capitalize;
}
.container1{
   max-width: 1300px;
   float: right;
   margin-right: 50px;
}
#logo { 
            height: auto; 
            margin-right: 10px; 
            width: 10%;
            float: right;
        }
        #header h1{
            text-align: center;
            color: white;
            margin-bottom: 50px;
            width: 100%;
            padding: 30px;
            
        }
      nav {
          display: flex;
          flex-direction: row;
          justify-content: space-between;
          align-items: center;
          padding: 10px;
      }

      nav ul {
          display: flex;
          flex-direction: row;
          list-style: none;
          margin: 0;
          padding: 0;
      }

      nav ul li {
          margin-right: 20px;
      }

      nav ul li:last-child {
          margin-right: 0;
      }

      nav a {
          color: black;
          text-decoration: none;
      }

      nav a:hover {
          color: orangered;
      }
.btn,
.option-btn,
.delete-btn{
   display: block;
   width: 100%;
   text-align: center;
   background-color: #10516e;
   color:var(--white);
   font-size: 1rem;
   padding:1rem 1rem;
   border-radius: .5rem;
   cursor: pointer;
   margin-top: 1rem;
}

.btn:hover,
.option-btn:hover,
.delete-btn:hover{
   background-color: var(--black);
}

.option-btn i,
.delete-btn i{
   padding-right: .5rem;
}

.option-btn{
   background-color: #10516e;
}

.delete-btn{
   margin-top: 0;
   background-color: #c54029;
}

.message{
   background-color: var(--blue);
   position: sticky;
   top:0; left:0;
   z-index: 10000;
   border-radius: .5rem;
   background-color: var(--white);
   padding:1.5rem 2rem;
   margin:0 auto;
   max-width: 1200px;
   display: flex;
   align-items: center;
   justify-content: space-between;
   gap:1.5rem;
}
.message span{
   font-size: 2rem;
   color:var(--black);
}

.message i{
   font-size: 2.5rem;
   color:var(--black);
   cursor: pointer;
}

.message i:hover{
   color:var(--red);
}

.header{
   background-color: var(--blue);
   position: sticky;
   top:0; left:0;
   z-index: 1000;
}

.header .flex{
   display: flex;
   align-items: center;
   padding:1.5rem 2rem;
   max-width: 1200px;
   margin:0 auto;
}

.header .flex .logo{
   margin-right: auto;
   font-size: 2.5rem;
   color:var(--white);
}

.header .flex .navbar a{
   margin-left: 2rem;
   font-size: 2rem;
   color:var(--white);
}

.header .flex .navbar a:hover{
   color:yellow;
}

.header .flex .cart{
   margin-left: 2rem;
   font-size: 2rem;
   color:var(--white);
}

.header .flex .cart:hover{
   color:yellow;
}

.header .flex .cart span{
   padding:.1rem .5rem;
   border-radius: .5rem;
   background-color: var(--white);
   color:var(--blue);
   font-size: 2rem;
}

#menu-btn{
   margin-left: 2rem;
   font-size: 3rem;
   cursor: pointer;
   color:var(--white);
   display: none;
}

.add-product-form{
   max-width: 45rem;
   background-color: var(--bg-color);
   border-radius: .5rem;
   padding:2rem;
   margin:0 auto;
   margin-top: 2rem;
}

.add-product-form h3{
   font-size: 2.5rem;
   margin-bottom: 1rem;
   color:var(--black);
   text-transform: uppercase;
   text-align: center;
}

.add-product-form .box{
   text-transform: none;
   padding:1rem 1rem;
   font-size: 1.2 rem;
   color:var(--black);
   border-radius: .5rem;
   background-color: var(--white);
   margin:1rem 0;
   width: 100%;
}

.display-product-table table{
   width: 100%;
   text-align: center;
}

.display-product-table table thead th{
   padding: 20px;
   font-size: 1rem;
   background-color: #2B2A4C;
   color:var(--white);
}

.display-product-table table td{
   padding:1.5rem;
   font-size: 1rem;
   color:var(--black);
}

.display-product-table table td:first-child{
   padding:0;
}

.display-product-table table tr:nth-child(even){
   background-color: var(--bg-color);
}

.display-product-table .empty{
   margin-bottom: 2rem;
   text-align: center;
   background-color: var(--bg-color);
   color:var(--black);
   font-size: 2rem;
   padding:1.5rem;
}

.edit-form-container{
   position: fixed;
   top:0; left:0;
   z-index: 1100;
   background-color: var(--dark-bg);
   padding:2rem;
   display: none;
   align-items: center;
   justify-content: center;
   min-height: 100vh;
   width: 100%;
}

.edit-form-container form{
   width: 50rem;
   border-radius: .5rem;
   background-color: var(--white);
   text-align: center;
   padding:2rem;
}

.edit-form-container form .box{
   width: 100%;
   background-color: var(--bg-color);
   border-radius: .5rem;
   margin:1rem 0;
   font-size: 1.7rem;
   color:var(--black);
   padding:1.2rem 1.4rem;
   text-transform: none;
}

.products .box-container{
   display: grid;
   grid-template-columns: repeat(auto-fit, 35rem);
   gap:1.5rem;
   justify-content: center;
}

.products .box-container .box{
   text-align: center;
   padding:2rem;
   box-shadow: var(--box-shadow);
   border:var(--border);
   border-radius: .5rem;
}

.products .box-container .box img{
   height: 25rem;
}

.products .box-container .box h3{
   margin:1rem 0;
   font-size: 2.5rem;
   color:var(--black);
}

.products .box-container .box .price{
   font-size: 2.5rem;
   color:var(--black);
}
.display-order{
   max-width: 50rem;
   background-color: var(--white);
   border-radius: .5rem;
   text-align: center;
   padding:1.5rem;
   margin:0 auto;
   margin-bottom: 2rem;
   box-shadow: var(--box-shadow);
   border:var(--border);
}

.display-order span{
   display: inline-block;
   border-radius: .5rem;
   background-color: var(--bg-color);
   padding:.5rem 1.5rem;
   font-size: 2rem;
   color:var(--black);
   margin:.5rem;
}

.display-order span.grand-total{
   width: 100%;
   background-color: var(--red);
   color:var(--white);
   padding:1rem;
   margin-top: 1rem;
}

.order-message-container{
   position: fixed;
   top:0; left:0;
   height: 100vh;
   overflow-y: scroll;
   overflow-x: hidden;
   padding:2rem;
   display: flex;
   align-items: center;
   justify-content: center;
   z-index: 1100;
   background-color: var(--dark-bg);
   width: 100%;
}

.order-message-container::-webkit-scrollbar{
   width: 1rem;
}

.order-message-container::-webkit-scrollbar-track{
   background-color: var(--dark-bg);
}

.order-message-container::-webkit-scrollbar-thumb{
   background-color: var(--blue);
}

.order-message-container .message-container{
   width: 50rem;
   background-color: var(--white);
   border-radius: .5rem;
   padding:2rem;
   text-align: center;
}

.order-message-container .message-container h3{
   font-size: 2.5rem;
   color:var(--black);
}

.order-message-container .message-container .order-detail{
   background-color: var(--bg-color);
   border-radius: .5rem;
   padding:1rem;
   margin:1rem 0;
}

.order-message-container .message-container .order-detail span{
   background-color: var(--white);
   border-radius: .5rem;
   color:var(--black);
   font-size: 2rem;
   display: inline-block;
   padding:1rem 1.5rem;
   margin:1rem;
}

.order-message-container .message-container .order-detail span.total{
   display: block;
   background: var(--red);
   color:var(--white);
}

.order-message-container .message-container .customer-details{
   margin:1.5rem 0;
}

.order-message-container .message-container .customer-details p{
   padding:1rem 0;
   font-size: 2rem;
   color:var(--black);
}

.order-message-container .message-container .customer-details p span{
   color:var(--blue);
   padding:0 .5rem;
   text-transform: none;
}
.logo-head img{
   width: 30%;
   margin: 1rem;
}
section{
   margin-top: 10px;
   margin-bottom: 20px;
   background-color: #fff;
   padding: 20px;
   box-shadow: 0 2px 4px rgba(0,0,0,0.2);
   width: calc(104% - 400px);
   float: right;
   margin-right: 20px;
}
section h2 {
  font-size: 24px;
  margin-bottom: 20px;

}
.dropbtn {
      color: black;
      padding: 16px;
      font-size: 1.5rem;
      font-weight: bold;
      border: none;
      cursor: pointer;

    }

    .dropdown {
      display: inline-block;
    }

    .dropdown-content {
      display: none;
      min-width: 160px;
      padding: 10px;
      margin-left: 60px;
    }

    .dropdown-content a {
      color: black;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
      font-size: 1rem;
    }

    .dropdown-content a:hover {
        background-color: #C5DFF8;
        border-radius: 20px;
    }

    .dropdown:hover .dropdown-content {
      display: block;
    }
.sidebar {
   height: 100%;
   width: 300px;
   position: fixed;
   top: 0;
   left: 0;
   background-color: #f2f2f2;
   overflow-x: hidden;
   padding-top: 20px;
}
.sidebar li {
   list-style-type: none; /* Remove the bullet points */
   padding: 0;
}
.sidebar a {
   padding: 6px 8px 6px 16px;
   text-decoration: none;
   font-size: 18px;
   color: black;
   display: block;
   margin-bottom: 20px;
   margin-left: 20px;
   margin-right: 20px;
}
.sidebar li:hover {
   opacity: 0.7;
}
.sidebar h3{
   margin-left: 20px;
   color: red;
}
.main {
   margin-left: 200px;
   padding: 20px;
}
.active{
   background-color: #C5DFF8;
   margin-right: 20px;
   border-radius: 20px;
}
.modal {
       display: none;
       position: fixed;
       z-index: 100;
       left: 0;
       top: 0;
       width: 100%;
       height: 100%;
       overflow: auto;
       background-color: rgba(0,0,0,0.5);
   }
   .modal-content {
       margin: 15% auto;
       padding: 20px;
       width: 50%;
       position: relative;
       border-radius: 5px;
   }
   .button{
      display: block;
      width: 30%;
      text-align: center;
      background-color: #10516e;
      color:var(--white);
      font-size: 1.3rem;
      padding:1rem 1rem;
      border-radius: .5rem;
      cursor: pointer;
      float: right;
      margin-right: 20px;
   }
   .button:hover{
      background-color: #c54029;
   }

   </style>

</head>
<body>
   
<?php

if(isset($message)){
   foreach($message as $message){
      echo '<div class="message"><span>'.$message.'</span><img src="image/close.png" style="width: 30px;" onclick="this.parentElement.style.display = `none`;"></div>';
   };
};

?>
<div id="header">
        <h1><img src="image/logo.png" alt="Your Logo" id="logo">
        Products</h1>
    </div>
   <div class="sidebar"><center>
      <div class="logo-head">
                    <a href="user_dashboard.php"><img src="image/Profile.png" alt=""></a><p style="margin-left: 10px; color: black; margin-bottom: 50px;"><?php echo $_SESSION['email_address']; ?></p>
     </div></center>
      <li><a href="manager_dashboard.php"><img src="image/dashboard.png" style="width: 30px; display: inline-block; vertical-align: middle;">
                  <span style="display: inline-block; vertical-align: middle; margin-left: 10px;">Dashboard</span></a></li>
                <li><a href="product_page.php" class="active">
                  <img src="image/gasul-product.png" style="width: 30px; display: inline-block; vertical-align: middle;">
                  <span style="display: inline-block; vertical-align: middle; margin-left: 10px;">Products</span>
                </a></li>
                <li><a href="orders.php"><img src="image/order.png" style="width: 30px; display: inline-block; vertical-align: middle;">
                  <span style="display: inline-block; vertical-align: middle; margin-left: 10px;">Orders</span></a></li>
                <li>
                  <div class="dropdown">
                      <a class="dropbtn"><img src="image/users.png" style="width: 30px; display: inline-block; vertical-align: middle;"><span style="display: inline-block; vertical-align: middle; margin-left: 10px;">Users<img src="image/dropdown.png" style="margin-left: 10px; margin-top: 10px; width: 20px; height: 16px"></a>
                      <div class="dropdown-content">
                      <a href="staff.php">Staff List</a>
                      <a href="user.php">Customer List</a>
                      </div>
                    </div></span></li> 
                <li><a href="sales.php"><img src="image/sale.png" style="width: 30px; display: inline-block; vertical-align: middle;">
                  <span style="display: inline-block; vertical-align: middle; margin-left: 10px;">Sales</span></a></li>
                 <li><a href="report.php"><img src="image/report.png" style="width: 30px; display: inline-block; vertical-align: middle;">
                  <span style="display: inline-block; vertical-align: middle; margin-left: 10px;">Reports</span></a></li>
                <li><a href="#sales"><img src="image/user-management.png" style="width: 30px; display: inline-block; vertical-align: middle;">
                  <span style="display: inline-block; vertical-align: middle; margin-left: 10px;">User Management</span></a></li><br><br>
                <li><a href="logout.php">
                    <img src="image/logout.png" style="width: 30px; display: inline-block; vertical-align: middle;"><span style="display: inline-block; vertical-align: middle; margin-left: 10px;">Logout</span></a></li>
    </div>
<div class="modal" id="addProductModal">
    <div class="modal-content">
        
        <form action="" method="post" class="add-product-form" enctype="multipart/form-data">
            <h3>Add a New Product</h3>
            <input type="text" name="p_name" placeholder="Enter the product name" class="box" required>
            <input type="number" name="p_price" min="0" placeholder="Enter the product price" class="box" required>
            <input type="number" name="p_stock" min="0" placeholder="Enter the product stock" class="box">
            <input type="file" name="p_image" accept="image/png, image/jpg, image/jpeg" class="box" required>
            <input type="submit" value="Add the Product" name="add_product" class="btn">
            <button type="button" class="option-btn" onclick="closeModal('addProductModal')">Cancel</button>
        </form>
    </div>
</div>
<button type="button" id="addProductButton" class="button">Add a New Product</button>
<section class="display-product-table">
  <h2>Products</h2>

  
   <table>

      <thead>
        <th>product ID</th>
        <th>product image</th>
        <th>product name</th>
        <th>product price</th>
        <th>product stocks</th>
        <th>action</th>
      </thead>

      <tbody>
         <?php
         
            $select_products = mysqli_query($conn, "SELECT * FROM `product_data`");
            if(mysqli_num_rows($select_products) > 0){
               while($row = mysqli_fetch_assoc($select_products)){
         ?>

         <tr>
            <td><?php echo $row['product_id']; ?></td>
            <td><img src="uploaded_img/<?php echo $row['product_image']; ?>" height="100" alt=""></td>
            <td><?php echo $row['product_name']; ?></td>
            <td>₱<?php echo $row['product_price']; ?></td>
            <td><?php echo $row['product_stocks']; ?></td>
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
      <img src="uploaded_img/<?php echo $fetch_edit['product_image']; ?>" height="200" alt="">
      <input type="hidden" name="update_p_id" value="<?php echo $fetch_edit['product_id']; ?>">
      <input type="text" class="box" required name="update_p_name" value="<?php echo $fetch_edit['product_name']; ?>">
      <input type="number" min="0" class="box" required name="update_p_price" value="<?php echo $fetch_edit['product_price']; ?>">
      <input type="number" min="0" class="box" required name="update_p_stock" value="<?php echo $fetch_edit['product_stocks']; ?>">
      <input type="file" class="box" name="update_p_image" accept="image/png, image/jpg, image/jpeg">
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
</body>
</html>
<script>
   document.addEventListener('DOMContentLoaded', function () {

    var addProductButton = document.getElementById('addProductButton');
    var addProductModal = document.getElementById('addProductModal');

    addProductButton.addEventListener('click', function () {

        addProductModal.style.display = 'block';
    });
    var closeModalButton = addProductModal.querySelector('.option-btn');
    closeModalButton.addEventListener('click', function () {

        addProductModal.style.display = 'none';
    });
});
document.querySelector('#close-edit').onclick = () =>{
   document.querySelector('.edit-form-container').style.display = 'none';
   window.location.href = 'product_page.php';
};
   function handleClick(item) {
            if (item === 'Logout') {
                console.log('Logging out...');
            } else {
                console.log(`Clicked on ${item}`);
            }
        }
</script>