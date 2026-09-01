<?php
include('dbconnect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $cpassword = isset($_POST['cpassword']) ? $_POST['cpassword'] : '';
    $admin_key = isset($_POST['admin_key']) ? trim($_POST['admin_key']) : '';

    // Define your admin key (for security)
    $correct_admin_key = "admin123";

    if ($admin_key !== $correct_admin_key) {
        echo "Invalid Admin Key!";
        exit;
    }

    if ($password !== $cpassword) {
        echo "Passwords do not match!";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format!";
        exit;
    }

    $stmt = $conn->prepare("SELECT COUNT(*) FROM admins WHERE email = ? OR username = ?");
    $stmt->bind_param("ss", $email, $username);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        echo "Admin Username or Email already exists!";
        exit;
    }

    $sql = $conn->prepare("INSERT INTO admins (username, email, password) VALUES (?, ?, ?)");

    if (!$sql) {
        die("Error preparing statement: " . $conn->error);
    }

    $password = password_hash($password, PASSWORD_DEFAULT);
    $sql->bind_param("sss", $username, $email, $password);

    if ($sql->execute()) {
        echo "Admin Registration Successful!";
    } else {
        echo "Error: " . $sql->error;
    }

    $sql->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Signup</title>
    <style>
        body {
            background-image: url(page3.jpg);
            background-size: cover;
            background-repeat: no-repeat;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .log {
            width: 400px;
            padding: 40px;
            background-color: rgba(180, 164, 164, 0.8);
            border-radius: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .log h1 {
            font-size: 36px;
            color: #333;
            margin-bottom: 20px;
        }

        .log label {
            font-size: 18px;
            margin-bottom: 8px;
            color: #555;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
        }

        .log button {
            width: 48%;
            padding: 12px;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            margin-top: 10px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .log button:hover {
            background-color: #F5A6C0;
        }

        .log .buttonn {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        .log button[type="submit"] {
            background-color: #EAACE2;
        }

        .log button[type="button"] {
            background-color: #F6C1E1;
        }
    </style>
</head>
<body>

    <div class="log">
        <h1>Admin Signup</h1>
        <form action="admin_signup.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>

            <label for="password">Create Password:</label>
            <input type="password" id="password" name="password" required><br>

            <label for="cpassword">Confirm Password:</label>
            <input type="password" id="cpassword" name="cpassword" required><br>

            <label for="admin_key">Admin Key:</label>
            <input type="password" id="admin_key" name="admin_key" required><br>

            <div class="buttonn">
                <button type="submit">Register as Admin</button>
                <button type="button" onclick="window.location.href = 'login.php';">Sign In</button>
            </div>
        </form>
    </div>

</body>
</html>
