<?php 
	session_start();
  include 'config.php';

  // if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
  //   header("Location: adminLogin.php");
  //   exit();
  
  $select_products = mysqli_query($conn, "SELECT COUNT(*) AS total_products FROM `product_data`");
  $total_products_result = mysqli_fetch_assoc($select_products);
  $total_products = $total_products_result['total_products'];

  $select_products = mysqli_query($conn, "SELECT SUM(product_stocks) AS total_stocks FROM `product_data`");
  $total_stocks_result = mysqli_fetch_assoc($select_products);
  $total_stocks = $total_stocks_result['total_stocks'];

  $select_orders = mysqli_query($conn, "SELECT COUNT(*) AS total_orders FROM `order_data`");
  $total_orders_result = mysqli_fetch_assoc($select_orders);
  $total_orders = $total_orders_result['total_orders'];
  
  $select_sales = mysqli_query($conn, "SELECT SUM(total_amount) AS total_sales FROM `order_data`");
  $total_sales_result = mysqli_fetch_assoc($select_sales);
  $total_sales = $total_sales_result['total_sales'];

 ?>

<!DOCTYPE html>
<html>
<head>
    <title>Manager Dashboard - Main</title>
    <link rel="icon" type="image/x-icon" href="image/logo1.png">
</head>
    <style>
    	body {
		    font-family: Arial, sans-serif;
		    margin: 0;
		    padding: 0;
		    background: linear-gradient(90deg, hsla(9, 58%, 47%, 1) 0%, hsla(215, 76%, 41%, 1) 100%);
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
		  padding: 20px;
		  width: calc(100% - 400px);
		  float: right;
		}

		section h2 {
		    font-size: 24px;
		    margin-bottom: 20px;

		}
		
		.header {
  		  position: relative;
  		  background-position: center;
  		  background-size: cover;
  		  height: 400px;
		}

		.mask {
  		  position: absolute;
  		  top: 0;
  		  left: 0;
  		  width: 100%;
  		  height: 100%;
        border-radius: 10px;
        display: flex;
		}

		.container-fluid {
		    padding: 20px;
		}

		.card {
  		  margin-bottom: 20px;
  		  border: 1px solid #e4e4e4;
  		  border-radius: 15px;
  		  background-color: #fff;
		}

		.card-body {
		    padding: 20px;
		}

		.card-title {
  		  color: #999;
  		  font-size: 14px;
  		  text-transform: uppercase;
  		  margin-bottom: 5px;
		}

		.h2 {
  		  font-size: 36px;
  		  font-weight: bold;
		}

		.img {
  		  display: flex;
  		  justify-content: center;
  		  align-items: center;
  		  height: 60px;
  		  width: 60px;
  		  border-radius: 50%;
  		  margin-right: 20px;
  		  color: red;
		}

		.text-danger {
		    color: #dc3545;
		}

		.text-primary {
		    color: #007bff;
		}

		.text-warning {
		    color: #ffc107;
		}

		.text-success {
		    color: #28a745;
		}

		.text-white {
		    color: #fff;
		}

		.rounded-circle {
		    border-radius: 50%;
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
        margin-right: 20px;
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
        .sidebar li {
    		    list-style-type: none; 
    		    padding: 0;
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
    </style>

<body>
<!-- <script type="text/javascript">
    var username = "<?php echo $_SESSION['username']; ?>";
    alert('Welcome, ' + username);
</script> -->
<div id="header">
        <h1><img src="image/logo.png" alt="Your Logo" id="logo"><?php echo $_SESSION['username']; ?>
        </h1>
</div>
   <div class="sidebar"><center>
    	<div class="logo-head">
                    <a href="user_dashboard.php"><img src="image/Profile.png" alt=""></a><p style="margin-left: 10px; color: black; margin-bottom: 50px;"><?php echo $_SESSION['username']; ?></p>
     </div></center>
                <li><a href="manager_dashboard.php" class="active">
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
                <li><a href="sales.php"><img src="image/sale.png" style="width: 30px; display: inline-block; vertical-align: middle;">
                  <span style="display: inline-block; vertical-align: middle; margin-left: 10px;">Sales</span></a></li>
                <li><a href="#sales"><img src="image/report.png" style="width: 30px; display: inline-block; vertical-align: middle;">
                  <span style="display: inline-block; vertical-align: middle; margin-left: 10px;">Reports</span></a></li>
                <li><a href="user_management.php"><img src="image/user-management.png" style="width: 30px; display: inline-block; vertical-align: middle;">
                  <span style="display: inline-block; vertical-align: middle; margin-left: 10px;">User Management</span></a></li><br><br>   
                <li><a href="logout.php">
                    <img src="image/logout.png" style="width: 30px; display: inline-block; vertical-align: middle;"><span style="display: inline-block; vertical-align: middle; margin-left: 10px;">Logout</span></a></li>
  </div>              
<section>
         <div style="background-color: #e9ecef;" class="header  pb-8 pt-5 pt-md-8">
      <span class="mask bg-gradient-dark opacity-8"></span>
      <div class="container-fluid">
        <div class="header-body">
          <div class="row">
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Products</h5>
                      <span class="h2 font-weight-bold mb-0"><?php echo $total_products; ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                        <img src="image/gasul-product.png">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
		  
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Oredrs/Purchase</h5>
                      <span class="h2 font-weight-bold mb-0"><?php echo $total_orders; ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                        <img src="image/orders.png">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Stocks</h5>
                      <span class="h2 font-weight-bold mb-0"><?php echo $total_stocks; ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                        <img src="image/orders.png">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
		  
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Sales</h5>
                      <span class="h2 font-weight-bold mb-0">₱<?php echo $total_sales; ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-green text-white rounded-circle shadow">
                        <img src="image/sales.png">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>



</body>

</html>
<script>
  function handleClick(item) {
            if (item === 'Logout') {
                console.log('Logging out...');
            } else {
                console.log(`Clicked on ${item}`);
            }
        }
</script>