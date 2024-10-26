<?php 
	session_start();
    include 'config.php';
 ?>

<!DOCTYPE html>
<html>
<head>
    <title>Manager Dashboard - Orders</title>
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
            margin-bottom: 20px;
			margin-right: 20px;
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
    </style>

<body>
<div id="header">
        <h1><img src="image/logo.png" alt="Your Logo" id="logo">
        Orders</h1>
    </div>
   <div class="sidebar"><center>
    	<div class="logo-head">
                    <a href="user_dashboard.php"><img src="image/Profile.png" alt=""></a><p style="margin-left: 21px; color: black; margin-bottom: 50px;"><?php echo $_SESSION['username']; ?></p>
     </div></center>
     	<li><a href="manager_dashboard.php"><img src="image/dashboard.png" style="width: 30px; display: inline-block; vertical-align: middle;">
                  <span style="display: inline-block; vertical-align: middle; margin-left: 10px;">Dashboard</span></a></li>
                <li><a href="product_page.php"><img src="image/gasul-product.png" style="width: 30px; display: inline-block; vertical-align: middle;">
                  <span style="display: inline-block; vertical-align: middle; margin-left: 10px;">Products</span></a></li>
                <li><a href="orders.php" class="active">
                  <img src="image/order.png" style="width: 30px; display: inline-block; vertical-align: middle;">
                  <span style="display: inline-block; vertical-align: middle; margin-left: 10px;">Orders</span>
                </a></li>
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
                 <li><a href="#sales"><img src="image/report.png" style="width: 30px; display: inline-block; vertical-align: middle;">
                  <span style="display: inline-block; vertical-align: middle; margin-left: 10px;">Reports</span></a></li>
                <li><a href="#sales"><img src="image/user-management.png" style="width: 30px; display: inline-block; vertical-align: middle;">
                  <span style="display: inline-block; vertical-align: middle; margin-left: 10px;">User Management</span></a></li><br><br> 
                <li><a href="logout.php">
                    <img src="image/logout.png" style="width: 30px; display: inline-block; vertical-align: middle;"><span style="display: inline-block; vertical-align: middle; margin-left: 10px;">Logout</span></a></li>
    </div>

    	<section>
        <h2>Orders</h2>
<?php 
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
        $id = $_POST['orderid'];
        $action = $_POST['orderaction'];
        
        $status = ($action == 'confirm') ? 'Confirmed' : 'Declined'; 
        $updateSql = "UPDATE `order_data` SET `order_status` = '$status' WHERE `order_id` = $id";
        mysqli_query($conn, $updateSql);
    }

    $sql = "SELECT * FROM `order_data` INNER JOIN user_data ON user_data.`user_id` = order_data.user_id ORDER BY order_data.status desc"; 
    $result = mysqli_query($conn, $sql);

    echo "<table>";
    echo "<tr>
            <th>Order ID</th>
            <th>User ID</th>
            <th>Customer Name</th>
            <th>Cylinder Option</th>
            <th>Service Option</th>
            <th>Total Amount</th>
            <th>Order Date</th>
            <th>Order Status</th>
          </tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>".$row['order_id']."</td>";
		    echo "<td>".$row['user_id']."</td>";
		    echo "<td>".$row['username']."</td>";
		    echo "<td>".$row['cylinder_option']."</td>";
            echo "<td>".$row['service_option']."</td>";
		    echo "<td>".$row['total_amount']."</td>";
		    echo "<td>".$row['order_date']."</td>";
		    echo "<td>".$row['status']."</td>";
        // echo "<td>";
        $id = $row['order_id']; 
        ?> 
        <!-- <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <input type='hidden' name='orderid' value='<?php echo $id; ?>'>
            <select name='orderaction'>
                <option value='confirm'>Confirm</option>
                <option value='cancel'>Decline</option>
            </select><br><br>
            <button type='submit' value='Submit' name='submit'>Submit</button> 
        </form> -->

        <?php 
        // echo "</td>";

        // echo "</tr>";
    }

    echo "</table>";
?>

				</tbody>
			</table>
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
