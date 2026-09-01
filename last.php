<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Learning Completed</title>
  <style>
    /* General Reset */
    body {
      font-family: 'Arial', sans-serif;
      margin: 0;
      padding: 0;
      background: linear-gradient(45deg, #25bee8, #f6f3f4); /* Gradient background */
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .completion-container {
      text-align: center;
      background-color: #fff;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      width: 350px;
      position: relative;
      animation: blastAnimation 3s ease-out infinite;
    }

    h1 {
      font-size: 2.5rem;
      color: #4caf50;
      margin-bottom: 20px;
    }

    /* Blasting Effect */
    .blast-emoji {
      font-size: 3rem;
      color: #ff4081;
      animation: blastEmojiAnimation 10s ease-out infinite;
      display: inline-block;
      margin-bottom: 20px;
    }

    /* Animations */
    @keyframes blastAnimation {
      0% {
        transform: scale(1);
        opacity: 0.8;
        box-shadow: 0 0 10px rgba(255, 64, 129, 0.5);
      }
      50% {
        transform: scale(1.2);
        opacity: 1;
        box-shadow: 0 0 50px rgba(255, 64, 129, 0.8);
      }
      100% {
        transform: scale(1);
        opacity: 0;
        box-shadow: 0 0 0 rgba(255, 64, 129, 0);
      }
    }

    @keyframes blastEmojiAnimation {
      0% {
        transform: rotate(0deg);
      }
      25% {
        transform: rotate(45deg);
      }
      50% {
        transform: rotate(90deg);
      }
      75% {
        transform: rotate(135deg);
      }
      100% {
        transform: rotate(180deg);
      }
    }

    .message {
      font-size: 1.2rem;
      color: #333;
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <div class="completion-container">
    <div class="blast-emoji">💥</div>
    <h1>Learning Completed!</h1>
    <div class="message">
      Congratulations! You have completed your language learning journey.
      <br>Well done! 🎉
    </div>
  </div>

  <script>
    // Redirect to languages.php after 10 seconds
    setTimeout(function() {
      window.location.href = "langauge.php"; // Redirect to languages.php
    }, 10000); // 10 seconds delay
  </script>
</body>
</html>
