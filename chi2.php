<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Video Control with Progress Bars</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      background-color: #f0f0f0;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100vh;
      position: relative;
    }

    .video-container {
      position: relative;
      width: 90%;
      max-width: 1200px;
    }

    .video {
      width: 100%;
      border-radius: 8px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
    }

    .video-range {
      position: absolute;
      bottom: 10px;
      left: 10px;
      right: 10px;
      appearance: none;
      background: rgba(255, 255, 255, 0.7);
      height: 5px;
      border-radius: 5px;
      outline: none;
      cursor: pointer;
      display: none;
    }

    .video-range::-webkit-slider-thumb {
      appearance: none;
      width: 10px;
      height: 10px;
      background: #333;
      border-radius: 50%;
    }

    .top-progress-bar {
      position: relative;
      margin: 20px auto;
      width: 80%;
      height: 5px;
      background-color: rgba(0, 0, 0, 0.1);
      border-radius: 5px;
    }

    .top-progress-bar .progress {
      height: 100%;
      background-color: #1bc13c;
      width: 0%;
      transition: width 0.2s ease;
      border-radius: 5px;
    }

    .next-btn {
      position: absolute;
      bottom: 20px;
      right: 20px;
      padding: 10px 20px;
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
      display: none;
    }

    .next-btn:hover {
      background-color: #0056b3;
    }

    .play-pause-btn {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      font-size: 48px;
      color: white;
      background: rgba(0, 0, 0, 0.5);
      border: none;
      border-radius: 50%;
      width: 80px;
      height: 80px;
      display: none;
      align-items: center;
      justify-content: center;
      cursor: pointer;
    }

    .video-container:hover .video-range,
    .video-container:hover .play-pause-btn {
      display: flex;
    }
  </style>
</head>
<body>
  <div class="top-progress-bar">
    <div class="progress" id="overallProgress"></div>
  </div>
  <div class="video-container">
    <video id="videoPlayer" class="video"></video>
    <button id="playPauseBtn" class="play-pause-btn">▶</button>
    <input type="range" id="videoRange" min="0" max="100" value="0" class="video-range">
    <button id="nextBtn" class="next-btn">Next</button>
  </div>

  <script>
    const videoPlayer = document.getElementById("videoPlayer");
    const videoRange = document.getElementById("videoRange");
    const nextBtn = document.getElementById("nextBtn");
    const overallProgress = document.getElementById("overallProgress");
    const playPauseBtn = document.getElementById("playPauseBtn");

    // List of video URLs
    const videoList = [
      "chinese1.mp4", // Replace with your video file paths
      "chinese2.mp4",
      "chinese3.mp4",
      "chinese4.mp4",
      "chinese5.mp4",
    ];

    let currentVideoIndex = 0;
    let overallProgressPercentage = 0;

    // Function to load a video
    function loadVideo(index) {
      if (index >= videoList.length) {
        console.log("All videos have been played.");
        return;
      }
      videoPlayer.src = videoList[index];
      videoPlayer.load();
      videoPlayer.play();
      playPauseBtn.textContent = "❚❚"; // Update button to pause state
    }

    // Function to toggle play/pause
    function togglePlayPause() {
      if (videoPlayer.paused) {
        videoPlayer.play();
        playPauseBtn.textContent = "❚❚";
      } else {
        videoPlayer.pause();
        playPauseBtn.textContent = "▶";
      }
    }

    playPauseBtn.addEventListener("click", togglePlayPause);

    // Update range slider based on video playback
    videoPlayer.addEventListener("timeupdate", () => {
      if (videoPlayer.duration) {
        const progress = (videoPlayer.currentTime / videoPlayer.duration) * 100;
        videoRange.value = progress;

        // Update overall progress
        const individualProgress = 1 / videoList.length;
        overallProgressPercentage = (currentVideoIndex + progress / 100) * individualProgress * 100;
        overallProgress.style.width = `${overallProgressPercentage}%`;
      }
    });

    // Seek video when range input changes
    videoRange.addEventListener("input", () => {
      if (videoPlayer.duration) {
        const seekTime = (videoRange.value / 100) * videoPlayer.duration;
        videoPlayer.currentTime = seekTime;
      }
    });

    // Automatically load the next video when the current video ends
videoPlayer.addEventListener("ended", () => {
  if (currentVideoIndex < videoList.length - 1) {
    nextBtn.style.display = "block";
  } else {
    console.log("No more videos to play.");
    // Automatically redirect to jap3.php after video finishes
    setTimeout(() => {
      window.location.href = 'session.php'; // Redirect to jap3.php after video finishes
    },2000); // 2 seconds delay before redirection
  }
});


    // Play the next video
    nextBtn.addEventListener("click", () => {
      currentVideoIndex++;
      if (currentVideoIndex < videoList.length) {
        loadVideo(currentVideoIndex);
        nextBtn.style.display = "none";
      } else {
        console.log("No more videos to play.");
      }
    });

    // Initialize the first video
    loadVideo(currentVideoIndex);
  </script>
</body>
</html>
