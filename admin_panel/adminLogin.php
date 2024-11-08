<?php
session_start();

$host = 'localhost'; 
$db = 'sop';
$user = 'root';
$pass = ''; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email_address = $_POST['email_address'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM user_data WHERE email_address = :email_address");
    $stmt->execute(['email_address' => $email_address]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['email_address'] = $user['email_address'];
        $_SESSION['role'] = $user['user_type'];

        if ($user['user_type'] === 'admin') {
            header("Location: admin_panel/manager_dashboard.php");
        } 
        exit();
    } else {
        echo "<script>alert('Invalid email address or password.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" type="text/css" href="admin_panel/css/style_log_reg.css">
</head>
<body>
    <div class="user_container">
         <div class="formlogin">
            <form action="login.php" method="POST">
                <img src="image/profile.png">
                <h2>Login Form</h2>

                <label for="email_address">Email Address:</label>
                <input type="email" id="email_address" name="email_address" placeholder="Enter Email" required><br><br>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter Password" required><br><br>

                <input type="submit" value="Login">
            </form>
        </div>
    </div>
</body>
</html>
