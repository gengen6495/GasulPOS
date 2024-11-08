<?php
    session_start(); 

    $host = 'localhost'; 
    $db = 'sop';
    $user = 'root';
    $pass = ''; 
    $conn = new mysqli($host, $user, $pass, $db);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $message = ''; 

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email_address = $_POST['email_address'];
        $password = $_POST['password'];
        
        $stmt = $conn->prepare("SELECT user_id, password, user_type FROM user_data WHERE email_address = ?");

        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("s", $email_address);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id, $hashed_password, $user_type);
            $stmt->fetch();
            
            if (password_verify($password, $hashed_password)) {
                $_SESSION['user_id'] = $user_id;
                $_SESSION['email_address'] = $email_address;
                $_SESSION['user_type'] = $user_type;

                if ($user_type === 'admin') {
                    header('Location: admin_panel/manager_dashboard.php'); 
                } else if ($user_type === 'cashier') {
                    header('Location: sales_interface.php'); 
                }
                exit();
            } else {
                echo "Incorrect password.";
            }
        } else {
            echo "No user found with that email.";
        }
        $stmt->close();
    }
    $conn->close(); 
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" type="text/css" href="css/style_log_reg.css">
</head>
<body>

<div class="login-container">
    <form method="post" action="">
        <div class="form-group">
            <h2>Login</h2>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email_address" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
            <button type="submit">Login</button>
        </div>
        <?php if ($message): ?>
            <div class="error-message"><?php echo $message; ?></div>
        <?php endif; ?>
    </form>
</div>

</body>
</html>
