<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lang";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch language data from the database
$sql = "SELECT * FROM languages";
$result = $conn->query($sql);

// Store language data
$languages = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $languages[] = $row;
    }
}

// Handle user form submission for profile update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST["userName"];
  $target_dir = "uploads/";
  $target_file = $target_dir . basename($_FILES["userPhoto"]["name"]);

  // Ensure the uploads directory exists
  if (!file_exists($target_dir)) {
      mkdir($target_dir, 0777, true);
  }

  if (move_uploaded_file($_FILES["userPhoto"]["tmp_name"], $target_file)) {
      $sql = "INSERT INTO savepoint (name, profile_image) VALUES ('$name', '$target_file')";
      if ($conn->query($sql) === TRUE) {
          echo "<script>alert('Profile updated successfully!');</script>";
      } else {
          echo "<script>alert('Error: " . $conn->error . "');</script>";
      }
  } else {
      echo "<script>alert('Error uploading file.');</script>";
  }
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Language Selection Steps</title>
  <link rel="stylesheet" href="language.css">
</head>
<body>
  <!-- User Profile -->
  <div class="user-profile">
    <img src="https://img.icons8.com/ios-filled/50/user-male-circle.png" alt="User Icon" id="userIcon" class="user-icon">
    <button id="logoutButton" class="logout-btn">Logout</button>
  </div>

  <!-- User Modal -->
  <div class="modal" id="userModal">
    <div class="modal-content">
      <button class="close-btn" id="closeModal">&times;</button>
      <h2>Update Profile</h2>
      <form id="userForm" method="POST" enctype="multipart/form-data" action="">
    <div class="form-group">
        <label for="userName">Name:</label>
        <input type="text" name="userName" id="userName" placeholder="Enter your name" required>
    </div>
    <div class="form-group">
        <label for="userPhoto">Photo:</label>
        <input type="file" name="userPhoto" id="userPhoto" accept="image/*" required>
    </div>
    <button type="submit" class="save-btn">Save</button>
</form>


    </div>
  </div>

  <!-- Lion Mascot -->
  <div class="mascot-container">
    <img src="run.png" alt="Lion Mascot" class="lion-mascot">
    <p class="mascot-caption">Welcome to Wordwander!</p>
  </div>

    <!-- Main Content -->
    <div class="container">
    <h1 style="text-align: center; color: rgb(34, 7, 41);">Select Your Language</h1>
  
  <!-- Main Content -->
  <div class="language-grid">
      <?php
      // Loop through the languages and display them as cards
      foreach ($languages as $language) {
        // Extract language details
        $languageName = $language['name'];
        // Ensure the paths are relative to where the images and audio are stored
        $imageUrl = 'admin/uploads/images/' . basename($language['image_url']);  // Path to image
        $audioUrl = 'admin/uploads/audio/' . basename($language['audio_url']);  // Path to audio
        $description = $language['description'];
        ?>

        <div class="language-card" onclick="selectLanguage(this)" data-language="<?php echo strtolower($languageName); ?>">
          <div class="checkmark">✔</div>
          <!-- Display the image for the language -->
          <img src="<?php echo $imageUrl; ?>" alt="<?php echo $languageName; ?>">
          <span><?php echo $languageName; ?></span>
          <!-- Display the description for the language -->
          <p id="<?php echo strtolower($languageName); ?>-info" class="language-info"><?php echo $description; ?></p>
          <!-- Audio for the language -->
          <audio id="<?php echo strtolower($languageName); ?>-audio" src="<?php echo $audioUrl; ?>"></audio>
        </div>

        <?php
      }
      ?>
    </div>
    <!-- Steps Section -->
    <div id="stepsSection" class="steps-section">
      <button id="proceedButton" class="next-step-button" style="display: none;">Proceed</button>
    </div>
  </div>
  </div>
  <script>
    document.getElementById("userForm").addEventListener("submit", function (event) {
    event.preventDefault();
    
    let formData = new FormData(this);
    
    fetch("upload.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(data => alert(data))
    .catch(error => console.error("Error:", error));
});

  </script>
  
  <script src="language.js"></script>
</body>
</html>
