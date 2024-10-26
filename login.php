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
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare statement to prevent SQL injection
    $stmt = $pdo->prepare("SELECT * FROM user_data WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verify password and check user type
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['user_type'];

        // Redirect based on user type
        if ($user['user_type'] === 'admin') {
            header("Location: admin_panel/manager_dashboard.php");
        } elseif ($user['user_type'] === 'cashier') {
            header("Location: sales_interface.php");
        }
        exit();
    } else {
        echo "Invalid username or password.";
    }
}
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
    <div class="user_container">
         <div class="formlogin">
            <form action="login.php" method="POST">
                <img src="image/profile.png">
                <h2>Login Form</h2>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" placeholder="Enter Username" required><br><br>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter Password" required><br><br>

                <input type="submit" value="Login">
            </form>
        </div>
    </div>
</body>
</html>
