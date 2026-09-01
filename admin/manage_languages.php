<?php
// Assuming you're already connected to the database using MySQLi or PDO
// Replace with your database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lang";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_language'])) {
    // Get form data
    $language_name = $_POST['language_name'];
    $language_description = $_POST['language_description'];

    // Handle image upload
    if (isset($_FILES['language_image']) && $_FILES['language_image']['error'] == 0) {
        $image_tmp_name = $_FILES['language_image']['tmp_name'];
        $image_name = $_FILES['language_image']['name'];
        
        // Directory to store images
        $image_upload_dir = 'uploads/images/';

        // Check if the directory exists, if not, create it
        if (!file_exists($image_upload_dir)) {
            mkdir($image_upload_dir, 0777, true); // Create the directory with permissions
        }

        $image_target_path = $image_upload_dir . basename($image_name);

        // Check if the image is uploaded successfully
        if (move_uploaded_file($image_tmp_name, $image_target_path)) {
            $image_url = $image_target_path;
        } else {
            die("Error uploading image.");
        }
    } else {
        die("Image not uploaded or invalid.");
    }

    // Handle audio file upload
    if (isset($_FILES['language_audio']) && $_FILES['language_audio']['error'] == 0) {
        $audio_tmp_name = $_FILES['language_audio']['tmp_name'];
        $audio_name = $_FILES['language_audio']['name'];
        
        // Directory to store audio files
        $audio_upload_dir = 'uploads/audio/';
        
        // Check if the directory exists, if not, create it
        if (!file_exists($audio_upload_dir)) {
            mkdir($audio_upload_dir, 0777, true); // Create the directory with permissions
        }

        $audio_target_path = $audio_upload_dir . basename($audio_name);

        // Check if the audio is uploaded successfully
        if (move_uploaded_file($audio_tmp_name, $audio_target_path)) {
            $audio_url = $audio_target_path;
        } else {
            die("Error uploading audio.");
        }
    } else {
        die("Audio not uploaded or invalid.");
    }

    // Insert the data into the database
    $sql = "INSERT INTO languages (name, image_url, audio_url, description) 
            VALUES ('$language_name', '$image_url', '$audio_url', '$language_description')";

    if ($conn->query($sql) === TRUE) {
        echo "New language added successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle language deletion
if (isset($_GET['delete_language'])) {
    $language_id = $_GET['delete_language'];

    // Prepare the delete query
    $sql_delete = "DELETE FROM languages WHERE id = ?";
    
    // Prepare and bind
    $stmt = $conn->prepare($sql_delete);
    $stmt->bind_param("i", $language_id);

    if ($stmt->execute()) {
        echo "Language deleted successfully.";
    } else {
        echo "Error deleting language: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();

    // Redirect to prevent reloading the page after deletion
    header("Location: manage_languages.php");
    exit();
}

// Fetch existing languages from the database
$sql = "SELECT * FROM languages";
$result = $conn->query($sql);

// Check if any languages exist and store them in an array
if ($result->num_rows > 0) {
    $languages = [];
    while($row = $result->fetch_assoc()) {
        $languages[] = $row;
    }
} else {
    $languages = [];
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Language Management</title>
    <link rel="stylesheet" href="../css/admin-panel.css">
    <style>
        /* General Layout */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        /* Navbar styles (assuming the navbar is fixed at the top) */
        .navbar {
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            background-color: #333;
            color: white;
            padding: 15px;
            z-index: 1000; /* Ensure it stays on top */
        }

        /* Give space below the navbar */
        .container {
            margin-top: 100px; /* Adjust this value based on your navbar height */
            display: flex;
            flex-direction: column; /* Stack vertically */
            align-items: center;
            width: 100%;
            padding: 20px;
        }

        /* Form Styles */
        h2 {
            color: #333;
            font-size: 26px;
            margin-bottom: 20px;
            text-align: center;
        }

        form {
            background-color: #fff;
            padding: 30px;
            margin: 20px auto;
            max-width: 900px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
        }

        form label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
            color: #555;
        }

        form input, form textarea, form button {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 16px;
        }

        form textarea {
            resize: vertical;
            height: 120px;
        }

        form input[type="file"] {
            padding: 5px;
        }

        form button {
            background-color: #2d3e2f;
            color: white;
            font-size: 16px;
            cursor: pointer;
            border: none;
            transition: background-color 0.3s;
        }

        form button:hover {
            background-color: #444;
        }

        /* Table Styles */
        table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
            padding: 16px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #2d3e2f;
            color: white;
        }

        table td img {
            width: 50px;
            height: 50px;
            border-radius: 4px;
        }

        table td audio {
            max-width: 120px;
        }

        table td a {
            color: #e74c3c;
            text-decoration: none;
            font-weight: bold;
            padding: 8px 12px;
            background-color: #f5c6cb;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        table td a:hover {
            background-color: #e74c3c;
            color: white;
        }

        /* Flex container for vertical layout */
        .container {
            display: flex;
            flex-direction: column; /* Stack vertically */
            align-items: center;
            width: 100%;
            margin-top: 80px;
            margin-left: 100px;
        }

        /* Ensure form and table are clearly spaced */
        .form-container, .table-container {
            width: 100%;
            max-width: 1000px;
            margin-bottom: 40px;
        }

        /* Responsive Styling */
        @media (max-width: 768px) {
            .form-container, .table-container {
                max-width: 100%;
                padding: 15px;
            }

            table th, table td {
                padding: 10px;
            }

            form input, form textarea, form button {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

<!-- Include Navbar -->
<?php include('navbar.php'); ?>

<!-- Main Container -->
<div class="container">

    <!-- Language Management Form -->
    <div class="form-container">
        <h2>Add New Language</h2>
        <form action="manage_languages.php" method="POST" enctype="multipart/form-data">
            <label for="language_name">Language Name:</label>
            <input type="text" id="language_name" name="language_name" required>
            
            <label for="language_image">Language Image:</label>
            <input type="file" id="language_image" name="language_image" accept="image/*" required>

            <label for="language_audio">Audio File (MP3):</label>
            <input type="file" id="language_audio" name="language_audio" accept="audio/mp3" required>

            <label for="language_description">Description:</label>
            <textarea id="language_description" name="language_description" required></textarea>

            <button type="submit" name="add_language">Add Language</button>
        </form>
    </div>

    <!-- List All Languages -->
    <div class="table-container">
        <h2>Manage Existing Languages</h2>
        <table>
            <thead>
                <tr>
                    <th>Language</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Audio</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Check if $languages is an array and not empty
                if (!empty($languages)) {
                    foreach ($languages as $language) {
                        echo "<tr>";
                        echo "<td>" . $language['name'] . "</td>";
                        echo "<td>" . $language['description'] . "</td>";
                        echo "<td><img src='" . $language['image_url'] . "' width='50' height='50'></td>";
                        echo "<td><audio controls><source src='" . $language['audio_url'] . "' type='audio/mp3'></audio></td>";
                        echo "<td><a href='manage_languages.php?delete_language=" . $language['id'] . "'>Delete</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No languages available.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</div>

</body>
</html>
