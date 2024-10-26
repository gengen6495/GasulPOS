<?php
session_start(); 
    include 'config.php';

    $error = "";
    if (isset($_POST['login'])) {
        $email = $_POST['email_address'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM `user_data` WHERE `email_address`='$email'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if ($row['password'] === $password) {
                session_start();
                $_SESSION['username'] = $row['username'];
                $_SESSION['email_address'] = $row['email_address'];
                $_SESSION['user_id'] = $row['user_id'];
                header("Location: manager_dashboard.php");
                exit();
            } else {
                $error = "Incorrect Password";
            }
        } else {
            $error = "Incorrect Email";
        }
    }
 ?>
<!DOCTYPE html>
<html>

<head>
    <title>Admin Login</title>
    <link rel="icon" type="image/x-icon" href="image/logo.png">
</head>
<style type="text/css">
    body{
        background: url('image/cover-orig.png') 80% no-repeat;
        background-size: cover;
        height: 100vh;

    }
    *{
        box-sizing: border-box;
    }

    .btn {
        background-color: #E86A33;
        color: #f2f2f2;
        padding: 1rem 3rem;
        border-radius: 0.9rem;
        margin-top: 1rem;
        text-decoration: none;
        border: none;
    }
    .btn:hover {
        background-color: #57C5B6;
        color: #333;
    }
    .wave{
        position: fixed;
        bottom: 0;
        left: 0;
        height: 100%;
        z-index: -1;
    }
    .img{
        display: flex;
        justify-content: flex-end;
        align-items: center;
    }
    .img img{
        width: 500px;
    }
    .formlogin{
        display: flex;
        justify-content: flex-start;
        align-items: center;
        text-align: center;
    }
    .formlogin img{
        height: 100px;
    }
    .formlogin h3{
        margin: 15px 0;
        color: #333;
        text-transform: uppercase;
        font-size: 2.9rem;
        padding: 10px;
    }
    .formlogin h1{
        margin: 15px 0;
        color: #333;
        text-transform: uppercase;
        font-size: 2.9rem;
        padding: 10px;
    }
    .user_container{
        width: 90vw;
        height: 90vh;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        grid-gap :7rem;
        padding: 0 2rem;
    }
    form {
        width: 500px;
        border: 1px solid white;
        margin-left: 20%;
        display: flex;
        flex-direction: column;
        outline: none;
        background: transparent;
        align-items: center;
        padding: 30px;
        border-radius: 40px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(5px);
        flex-wrap: wrap;
        justify-content: space-between;
    }
    select, input[type=text], input[type=password]{
        padding: 30px;
        border: none;
        outline: none;
        max-width: 400px;
        position: relative;
        width: 100%;
        height: 10px;
        margin: 10px 0;
        border-radius: 1.5rem;
        background-color: #9EDDFF;
    }
    

</style>

<body>
    <!--  <div class="logo-head">
        <a href="manager_dashboard.php"><img src="https://img.icons8.com/?size=512&id=80689&format=png" alt="" height="50px"></a>
    </div> -->
   <div class="user_container">
        <!-- <div class="img">
            <img src="image/front1.jpg">
        </div> -->
        <div class="formlogin">
            <form id="adminLoginForm" method="POST">
                <img src="image/profile.png">
                <h1>Login</h1>
                <label for="email_address">Email</label>
                <input type="text" id="email_address" placeholder="Enter Email Address" name="email_address" required>

                <label for="password">Password</label>
                <input type="password" id="password" placeholder="Enter Password" name="password" required>
                <button class="btn" name="login">Login</button>

                <?php if ($error): ?>
                    <p style="color: red;"><?php echo $error; ?></p>
                <?php endif; ?>

            </form>
        </div>

    </div>
</body>

</html>


