<?php 
    session_start();
    include 'config.php';

  if(isset($_POST['add_user'])){
     $p_name = $_POST['p_name'];
     $p_No = $_POST['p_No'];
     $p_email = $_POST['p_email'];
     $p_pass = $_POST['p_pass'];

     $insert_query = mysqli_query($conn, "INSERT INTO `user_data`(username, contact_number, email_address, password, user_type) VALUES('$p_name', '$p_No', '$p_email', '$p_pass', 'cashier')") or die('query failed');

     if($insert_query){
        $message[] = 'New User add succesfully';
     }else{
        $message[] = 'could not add user';
     }
  };

    if(isset($_POST['update_product'])){
     $update_p_id = $_POST['update_p_id'];
     $update_p_name = $_POST['update_p_name'];
     $update_p_price = $_POST['update_p_price'];
     $update_p_stock = $_POST['update_p_stock'];
     $update_p_image = $_FILES['update_p_image']['username'];
     $update_p_image_tmp_name = $_FILES['update_p_image']['tmp_name'];

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
<html>
<head>
    <title>Manager Dashboard - Users</title>
    <link rel="icon" type="image/x-icon" href="image/logo1.png">
</head>
    <style>
        body {
            background: linear-gradient(90deg, hsla(9, 58%, 47%, 1) 0%, hsla(215, 76%, 41%, 1) 100%) no-repeat;
            background-size: cover;
            height: 100vh;

        }
        *{
           font-family: 'Poppins', sans-serif;
           box-sizing: border-box;
           outline: none; border:none;
           text-decoration: none;
           text-transform: capitalize;
        }
        header {
            background-color: #19A7CE;
            color: black;
            padding: 10px;
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
            width: 95%;
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

        section {
            margin-top: 10px;
            margin-right: 20px;
            margin-bottom: 20px;
            background-color: #fff;
            padding: 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
            width: calc(103% - 400px);
            float: right;
        }

        section h2 {
            font-size: 24px;
            margin-bottom: 20px;

        }
        table {
            width: 100%;
            text-align: center;
        }

        table th, table td {
            padding:1.5rem;
           font-size: 1rem;
           color: black;
        }

        table th {
            background-color: #2B2A4C;
            color: white;
            font-weight: bold;  
        }

        table tr:nth-child(even) {
            background-color: #f5f5f5;
        }

        button {
            padding: 10px 20px;
            background-color: orange;
            color: black;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #B5F1CC;
        }

        form label {
            display: block;
            margin-bottom: 5px;
            font-size: 16px;
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
    .add-user-form{
   max-width: 45rem;
   background-color: #eee;
   border-radius: .5rem;
   padding:2rem;
   margin:0 auto;
   margin-top: 2rem;
}

.add-user-form h3{
   font-size: 2.5rem;
   margin-bottom: 1rem;
   color:var(--black);
   text-transform: uppercase;
   text-align: center;
}

.add-user-form .box{
   text-transform: none;
   padding:1rem 1rem;
   font-size: 1.2 rem;
   color:var(--black);
   border-radius: .5rem;
   background-color: white;
   margin:1rem 0;
   width: 100%;
}
.btn,
.option-btn{
   display: block;
   width: 100%;
   text-align: center;
   background-color: #10516e;
   color:white;
   font-size: 1rem;
   padding:1rem 1rem;
   border-radius: .5rem;
   cursor: pointer;
   margin-top: 1rem;
}

.btn:hover,
.option-btn:hover{
   background-color: black;
}
.option-btn{
   background-color: #10516e;
}
        .logo-head img{
            width: 30%;
            margin: 1rem;
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
            list-style-type: none;
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
              margin-bottom: 10px;
              color: white;
           }
           .button:hover{
              background-color: #c54029;
           }
    </style>

<body>
<div id="header">
        <h1><img src="image/logo.png" alt="Your Logo" id="logo">
        Users</h1>
    </div>
   <div class="sidebar"><center>
        <div class="logo-head">
                    <a href="user_dashboard.php"><img src="image/Profile.png" alt=""></a><p style="margin-left: 21px; color: black; margin-bottom: 50px;"><?php echo $_SESSION['username']; ?></p>
     </div></center>
        <li><a href="manager_dashboard.php"><img src="image/dashboard.png" style="width: 30px; display: inline-block; vertical-align: middle;">
                  <span style="display: inline-block; vertical-align: middle; margin-left: 10px;">Dashboard</span></a></li>
                <li><a href="product_page.php"><img src="image/gasul-product.png" style="width: 30px; display: inline-block; vertical-align: middle;">
                  <span style="display: inline-block; vertical-align: middle; margin-left: 10px;">Products</span></a></li> 
                <li><a href="orders.php">
                  <img src="image/order.png" style="width: 30px; display: inline-block; vertical-align: middle;">
                  <span style="display: inline-block; vertical-align: middle; margin-left: 10px;">Orders</span>
                </a></li>
                <li>
                  <div class="dropdown">
                      <a class="dropbtn"><img src="image/users.png" style="width: 30px; display: inline-block; vertical-align: middle;"><span style="display: inline-block; vertical-align: middle; margin-left: 10px;">Users<img src="image/dropdown.png" style="margin-left: 10px; margin-top: 10px; width: 20px; height: 16px"></a>
                      <div class="dropdown-content">
                      <a class="active" href="staff.php">Staff List</a>
                      <a href="user.php">Customer List</a>
                      </div>
                    </div></span></li>
                <li><a href="sales.php"><img src="image/sale.png" style="width: 30px; display: inline-block; vertical-align: middle;">
                  <span style="display: inline-block; vertical-align: middle; margin-left: 10px;">Sales</span></a></li>
                 <li><a href="#sales"><img src="image/report.png" style="width: 30px; display: inline-block; vertical-align: middle;">
                  <span style="display: inline-block; vertical-align: middle; margin-left: 10px;">Reports</span></a></li>
                <li><a href="#sales"><img src="image/user-management.png" style="width: 30px; display: inline-block; vertical-align: middle;">
                  <span style="display: inline-block; vertical-align: middle; margin-left: 10px;">User Management</span></a></li><br><br> 
                <li><a href="logout.php">
                    <img src="image/logout.png" style="width: 30px; display: inline-block; vertical-align: middle;"><span style="display: inline-block; vertical-align: middle; margin-left: 10px;">Logout</span></a></li>
    </div><button type="button" id="addUserButton" class="button">Add a New Staff</button>
<div class="modal" id="addUserModal">
    <div class="modal-content">
        
        <form action="" method="post" class="add-user-form" enctype="multipart/form-data">
            <h3>New Staff</h3>
            <input type="text" name="p_name" placeholder="Enter full name" class="box" required>
            <input type="number" name="p_No" min="0" placeholder="Enter the Contact Number" class="box" required>
            <input type="text" name="p_email" placeholder="Enter the Email Address" class="box">
            <input type="text" name="p_pass" placeholder="Enter the Password" class="box" required>
            <input type="submit" value="Add New Customer" name="add_user" class="btn">
            <button type="button" class="option-btn" onclick="closeModal('addUserModal')">Cancel</button>
        </form>
    </div>
</div>

    <section>
        <h2>Staff List</h2>
        
        
    <?php 

        $sql = "SELECT * FROM `user_data` WHERE user_type = 'cashier'";
        $result = mysqli_query($conn, $sql);

        
        echo "<table>";
        echo "<tr><th>User ID</th>
        <th>Name</th>
        <th>Email Address</th>
        <th>Contact Number</th>
        <th>User Type</th>
        <th>Date Created</th></tr>";

    
        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>".$row['user_id']."</td>";
            echo "<td>".$row['username']."</td>";
            echo "<td>".$row['email_address']."</td>";
            echo "<td>".$row['contact_number']."</td>";
            echo "<td>".$row['user_type']."</td>";
            echo "<td>".$row['created_at']."</td>";
            $id = $row['user_id']; 
            ?> 
        <?php 
        }

        echo "</table>";

        ?>

    </section>

    <script>
       document.addEventListener('DOMContentLoaded', function () {
        
        var addUserButton = document.getElementById('addUserButton');
        var addUserModal = document.getElementById('addUserModal');

        addUserButton.addEventListener('click', function () {

            addUserModal.style.display = 'block';
        });
        var closeModalButton = addUserModal.querySelector('.option-btn');
        closeModalButton.addEventListener('click', function () {
            addUserModal.style.display = 'none';
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

</body>

</html>
