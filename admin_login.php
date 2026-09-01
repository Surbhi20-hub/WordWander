<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['admin_username'];
    $password = $_POST['admin_password'];

    // Validate credentials (replace with your actual validation logic)
    if ($username === 'your_admin_username' && $password === 'your_admin_password') {
        // Set session variables or perform other login success actions
        $_SESSION['admin_logged_in'] = true;

        // Redirect to the admin dashboard or desired page
        header('Location: admin/admin.php');
        exit();
    } else {
        // Handle login failure (e.g., redirect back with an error message)
        header('Location: admin_login.php?error=invalid_credentials');
        exit();
    }
} else {
    // If the request method is not POST, redirect to the login form
    header('Location: admin/admin.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body {
            background-image: url("page1");
            background-size: cover;
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
        }
        .log {
            width: 400px;
            padding: 40px;
            background-color: rgba(255, 255, 255, 0.8);
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
            align-self: flex-start;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: 2px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            box-sizing: border-box;
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
        .buttonn {
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
        <h1><b>Admin Login</b></h1>
        <form action="admin_login.php" method="POST">
            <label for="admin_username"><b>Username:</b></label>
            <input type="text" id="admin_username" name="admin_username" required>

            <label for="admin_password"><b>Password:</b></label>
            <input type="password" id="admin_password" name="admin_password" required>

            <div class="buttonn">
                <button type="submit" name="admin_login">Login</button>
                <button type="button" onclick="window.location.href = 'index.php';">Back to Home</button>
            </div>
        </form>
    </div>
</body>
</html>
