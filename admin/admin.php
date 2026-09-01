<?php
// Database connection setup
$host = "localhost";
$user = "root";
$password = "";
$dbname = "lang";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to fetch users based on time frame
function fetchUsersByTimeFrame($timeFrame) {
    global $conn;

    $query = "";
    $currentDate = date('Y-m-d'); // Get current date

    if ($timeFrame == "today") {
        $query = "SELECT * FROM users WHERE DATE(created_at) = '$currentDate'";
    } elseif ($timeFrame == "weekly") {
        $query = "SELECT * FROM users WHERE created_at >= CURDATE() - INTERVAL 1 WEEK";
    } elseif ($timeFrame == "monthly") {
        $query = "SELECT * FROM users WHERE created_at >= CURDATE() - INTERVAL 1 MONTH";
    }

    $result = $conn->query($query);
    $users = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }

    return $users;
}

// Check if delete_user is set
if (isset($_GET['delete_user'])) {
    $userId = $_GET['delete_user'];

    // Delete user from the database
    $query = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        echo "<script>alert('User deleted successfully');</script>";
    } else {
        echo "<script>alert('Failed to delete user');</script>";
    }

    $stmt->close();
}

// Determine the timeframe (today, weekly, monthly) from the URL query parameter
$timeFrame = isset($_GET['timeframe']) ? $_GET['timeframe'] : 'today';
$users = fetchUsersByTimeFrame($timeFrame);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
        /* General body styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
            background-color: #f4f4f9;
        }

        /* Sidebar styles (navbar.php) */
        .sidebar {
            width: 250px;
            background-color: #2d3e2f;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 20px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            box-shadow: 2px 0px 5px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
        }

        .sidebar h2 {
            margin-bottom: 20px;
            font-size: 24px;
            text-align: center;
        }

        .sidebar nav {
            flex-grow: 1;
        }

        .sidebar nav a {
            display: block;
            padding: 12px;
            margin: 10px 0;
            color: white;
            text-decoration: none;
            background-color: #3a4e3f;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .sidebar nav a:hover {
            background-color: #2d3e2f;
        }

        .sidebar footer {
            font-size: 14px;
            text-align: center;
            color: #ddd;
        }

        /* Main content area */
        .main-content {
            margin-left: 290px; /* Push the content to the right of the sidebar */
            background-color: #ffffff;
            padding: 20px;
            overflow-y: auto;
            height: 100vh; /* Ensure the content area takes the full height */
            width: calc(100% - 250px); /* Ensure the content takes the remaining width */
            box-sizing: border-box;
        }

        /* Header Styles */
        .header {
            background-color: #28a745;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 24px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        /* Card Styles */
        .card {
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .card h3 {
            margin-top: 0;
            color: #333;
        }

        .card .button {
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .card .button:hover {
            background-color: #218838;
        }

        /* Table Styles */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th, .table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .table th {
            background-color: #28a745;
            color: white;
        }

        .table td {
            background-color: #f9f9f9;
        }

        .table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<?php include('navbar.php'); ?>

<!-- Main Content Section -->
<div class="main-content">
    <div class="header">Admin Dashboard</div>

    <!-- User Management Section -->
    <div id="user-management" class="card">
        <h3>User Management</h3>

        <div>
            <a href="?timeframe=today" class="button">Today</a>
            <a href="?timeframe=weekly" class="button">This Week</a>
            <a href="?timeframe=monthly" class="button">This Month</a>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Display users based on the selected timeframe
                if (count($users) > 0) {
                    foreach ($users as $user) {
                        echo "<tr>";
                        echo "<td>{$user['username']}</td>";
                        echo "<td>{$user['email']}</td>";
                        echo "<td>{$user['created_at']}</td>";
                        echo "<td><a href='?delete_user={$user['id']}' class='button'>Delete</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No users found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>

<?php
// Close the connection
$conn->close();
?>
