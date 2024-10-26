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
    $email_address = $_POST['email_address'];
    $contact_number = $_POST['contact_number'];
    $password = $_POST['password'];
    $userType = $_POST['user_type']; 

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO user_data (username, email_address, contact_number, password, user_type) VALUES (:username, :email_address, :contact_number, :password, :user_type)");
    $stmt->execute(['username' => $username, 'email_address' => $email_address, 'contact_number' => $contact_number, 'password' => $hashedPassword, 'user_type' => $userType]);

    echo "User registered successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="stylesheet" type="text/css" href="css/style_log_reg.css">
</head>
<body>
    <header class="back">
        <a href="home.php"><img src="image/back.gif"></a>
    </header>
    <div class="formlogin">
        <form action="register.php" method="POST">
            <img src="image/profile.png">
            <h2>Register New User</h2>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br><br>

            <label for="email_address">Email Address:</label>
            <input type="email" id="email_address" name="email_address" required><br><br>

            <label for="contact_number">Contact Number:</label>
            <input type="number" id="contact_number" name="contact_number" required><br><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>

            <label for="user_type">User Type:</label>
            <select id="user_type" name="user_type" required>
                <option value="admin">Admin</option>
                <option value="cashier">Cashier</option>
            </select><br><br>

            <input type="submit" value="Register">
        </form>
    </div>
</body>
</html>
