<?php
session_start();
include 'dbconnect.php'; // Database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    // Check if passwords match
    if ($password !== $cpassword) {
        echo "<script>alert('Passwords do not match!'); window.location.href='signup.php';</script>";
        exit();
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<script>alert('Email already registered!'); window.location.href='signup.php';</script>";
        exit();
    }
    $stmt->close();

    // Insert new user
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("sss", $username, $email, $hashedPassword);

    if ($stmt->execute()) {
        echo "<script>alert('Signup successful! You can now login.'); window.location.href='login.php';</script>";
    } else {
        echo "<script>alert('Error during signup. Please try again.');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Languages</title>
    <style>
        body {
            background-image: url(page3.jpg);
            background-size: cover;
            background-repeat: no-repeat;
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
            background-color: rgba(213, 204, 204, 0.8);
            border-radius: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .log h1 {
            font-size: 36px;
            margin-bottom: 20px;
            color: #333;
        }
        .log label {
            font-size: 20px;
            margin-bottom: 8px;
            color: #555;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: 2px solid #ccc;
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
            margin-left: 5px;
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
        <h1><b>Signup Here</b></h1>
        <form action="signup.php" method="POST">
            <label for="username"><b>Username:</b></label>
            <input type="text" id="username" name="username" required><br><br>

            <label for="email"><b>Email:</b></label>
            <input type="email" id="email" name="email" required><br><br>

            <label for="password"><b>Create password:</b></label>
            <input type="password" id="password" name="password" required><br>

            <label for="cpassword"><b>Confirm password:</b></label>
            <input type="password" id="cpassword" name="cpassword" required><br>

            <div class="buttonn">
                <button type="submit" name="signup">Sign Up</button>
                <button type="button" onclick="window.location.href = 'login.php';">Sign In</button>
                <button type="button" onclick="window.location.href = 'admin_signup.php';">Admin Signup</button>
            </div>
        </form>
    </div>
</body>
</html>
