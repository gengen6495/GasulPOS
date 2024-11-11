<?php 
  session_start();
    include 'config.php';
 ?>

<!DOCTYPE html>
<html>
<head>
    <title>Manager Dashboard - Sales</title>
    <link rel="icon" type="image/x-icon" href="image/logo1.png">
</head>
    <style>
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
        background-color: #fff;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        width: calc(100% - 400px);
        float: right;
    }

    section h2 {
        font-size: 24px;
        margin-bottom: 20px;

    }
    table {
        width: 100%;
        border-collapse: collapse;
    }

    table th, table td {
        padding: 10px;
        border: 1px solid #ddd;
    }

    table th {
        background-color: #e9ecef;
        color: black;
            font-weight: bold;
    }

    table tr:nth-child(even) {
        background-color: #f5f5f5;
    }

    button {
        padding: 10px 20px;
        background-color: orange;
        color: #fff;
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
        .main {
            margin-left: 200px;
            padding: 20px;
        }
        .active{
            background-color: #C5DFF8;
            margin-right: 20px;
            margin-left: 20px;
            border-radius: 20px;
        }
    </style>

<body>
<div id="header">
        <h1><img src="image/logo.png" alt="Your Logo" id="logo">
        Sales</h1>
    </div>
   <div class="sidebar"><center>
      <div class="logo-head">
                    <a href="user_dashboard.php"><img src="image/Profile.png" alt=""></a><p style="margin-left: 15px; color: black; margin-bottom: 50px;"><?php echo $_SESSION['email_address']; ?></p>
     </div></center>
                <li><a href="manager_dashboard.php">
                  <img src="image/dashboard.png" style="width: 30px; display: inline-block; vertical-align: middle;">
                  <span style="display: inline-block; vertical-align: middle; margin-left: 10px;">Dashboard</span>
                </a></li>
                <li><a href="product_page.php"><img src="image/gasul-product.png" style="width: 30px; display: inline-block; vertical-align: middle;">
                  <span style="display: inline-block; vertical-align: middle; margin-left: 10px;">Products</span></a></li>
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
                <li><a href="sales.php" class="active"><img src="image/sale.png" style="width: 30px; display: inline-block; vertical-align: middle;">
                  <span style="display: inline-block; vertical-align: middle; margin-left: 10px;">Sales</span></a></li>
                <li><a href="report.php"><img src="image/report.png" style="width: 30px; display: inline-block; vertical-align: middle;">
                  <span style="display: inline-block; vertical-align: middle; margin-left: 10px;">Reports</span></a></li>
                <li><a href="#sales"><img src="image/user-management.png" style="width: 30px; display: inline-block; vertical-align: middle;">
                  <span style="display: inline-block; vertical-align: middle; margin-left: 10px;">User Management</span></a></li><br><br>   
                <li><a href="logout.php">
                    <img src="image/logout.png" style="width: 30px; display: inline-block; vertical-align: middle;"><span style="display: inline-block; vertical-align: middle; margin-left: 10px;">Logout</span></a></li>
    </div>

      <section>
        <h2>Sales</h2>
<!-- <?php
$sql = "SELECT * FROM payment_data";
$result = mysqli_query($conn, $sql);


echo '<table>';
echo '<tr><th>PaymentID</th><th>AppointmentID</th><th>Payment_method</th><th>Payment_Amount</th><th>Actions</th></tr>';
while ($row = mysqli_fetch_assoc($result)) {
    echo '<tr>';
    echo '<td>' . $row['PaymentID'] . '</td>';
    echo '<td>' . $row['AppointmentID'] . '</td>';
    echo '<td>' . $row['payment_method'] . '</td>';
    echo '<td>' . $row['payment_amount'] . '</td>';
    echo '<td><button onclick="approvePayment(' . $row['PaymentID'] . ')">Approve</button>&nbsp;&nbsp;&nbsp<button onclick="rejectPayment(' . $row['PaymentID'] . ')">Reject</button></td>';
    echo '</tr>';
}
echo '</table>';


?> -->
    </section>

    <script>
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
