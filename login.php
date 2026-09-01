<?php
// Include database connection
include('dbconnect.php');

// Start session to store user data after login
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format!";
        exit;
    }

    // Prepare SQL query to fetch user by email
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email); // "s" for string
    $stmt->execute();
    $stmt->store_result();
    
    // Check if user exists
    if ($stmt->num_rows == 0) {
        echo "No user found with this email.";
        exit;
    }

    // Bind result variables
    $stmt->bind_result($id, $username, $hashed_password);

    // Fetch user data
    $stmt->fetch();

    // Verify password
    if (password_verify($password, $hashed_password)) {
        // Password is correct, start session and store user info
        $_SESSION['user_id'] = $id;
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;

        // Redirect to a dashboard or user profile page
        header("Location: langauge.php");
        exit;
    } else {
        echo "Incorrect password!";
    }

    // Close statement
    $stmt->close();
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
            background-color: rgba(227, 213, 213, 0.8);
            border-radius: 20px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.2);
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
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: 2px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
        }
        .button-container {
            display: flex;
            justify-content: center;
            width: 100%;
            gap: 15px;
            margin-top: 15px;
        }
        .log button,
        .admin-btn {
            font-size: 16px;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }
        .log button {
            background-color: #F5A6C0;
            color: white;
        }
        .log button:hover {
            background-color: #EAACE2;
        }
        .admin-btn {
            background-color: #EAACE2;
            color: white;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        .admin-btn:hover {
            background-color: #F5A6C0;
        }
        .log a {
            font-size: 14px;
            text-decoration: none;
            margin-top: 10px;
        }
        .log a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="log">
        <h1><b>Login Here</b></h1>
        <form action="login.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <div class="button-container">
                <button type="submit">User Login</button>
                <a href="admin_login.php" class="admin-btn">Admin Login</a>
            </div>
        </form>
        <a href="signup.php">Create a new account?</a>
    </div>
</body>
</html>
