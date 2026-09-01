<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Language Session Selection</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url(page4.avif);
            background-repeat: no-repeat;
            background-size: cover;
        }
        .container {
            display: flex;
            flex-direction: column;
            gap: 40px;
            margin-bottom: 100px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .capsule-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .capsule {
            width: 320px;
            padding: 25px;
            background-color: #aaa4ad;
            color: rgb(12, 6, 6);
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50px;
            text-align: center;
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
            transition: transform 0.2s, box-shadow 0.2s;
            word-wrap: break-word;
            margin-bottom: 15px;
        }
        .capsule:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        #sessions {
            text-align: center;
            margin-bottom: 40px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Select the session:</h2>
        <div id="sessions">
            <!-- Dynamic session links will appear here based on the selected language -->
        </div>
    </div>

    <script>
        window.onload = function() {
            // Get language from URL parameter
            const urlParams = new URLSearchParams(window.location.search);
            const selectedLanguage = urlParams.get('lang') || 'spanish'; // Default to Spanish if no parameter is given

            let sessionLinks = {
                spanish: [
                    { title: "Session 1", description: "It contains a simple vocabulary quiz.", link: "span1.php" },
                    { title: "Session 2", description: "It contains only the videos by which accents are get to known.", link: "span2.php" },
                    { title: "Session 3", description: "It contains quiz on audio, video, image or simple as text.", link: "span3.php" }
                ],
                chinese: [
                    { title: "Session 1", description: "It contains a simple vocabulary quiz.", link: "chi1.php" },
                    { title: "Session 2", description: "It contains only the videos by which accents are get to known.", link: "chi2.php" },
                    { title: "Session 3", description: "It contains quiz on audio, video, image or simple as text.", link: "chi3.php" }
                ],
                french: [
                    { title: "Session 1", description: "It contains a simple vocabulary quiz.", link: "fren1.php" },
                    { title: "Session 2", description: "It contains only the videos by which accents are get to known.", link: "fren2.php" },
                    { title: "Session 3", description: "It contains quiz on audio, video, image or simple as text.", link: "fren3.php" }
                ],
                japanese: [
                    { title: "Session 1", description: "It contains a simple vocabulary quiz.", link: "jap1.php" },
                    { title: "Session 2", description: "It contains only the videos by which accents are get to known.", link: "jap2.php" },
                    { title: "Session 3", description: "It contains quiz on audio, video, image or simple as text.", link: "jap3.php" }
                ],
                german: [
                    { title: "Session 1", description: "It contains a simple vocabulary quiz.", link: "ger1.php" },
                    { title: "Session 2", description: "It contains only the videos by which accents are get to known.", link: "ger2.php" },
                    { title: "Session 3", description: "It contains quiz on audio, video, image or simple as text.", link: "ger3.php" }
                ]
            };

            const sessionsContainer = document.getElementById('sessions');
            sessionsContainer.innerHTML = '';

            const languageSessions = sessionLinks[selectedLanguage] || sessionLinks['spanish'];

            languageSessions.forEach(session => {
                const sessionLink = document.createElement('a');
                sessionLink.href = session.link;
                sessionLink.classList.add('capsule');
                sessionLink.innerHTML = `${session.title}<br><br>${session.description}`;
                sessionsContainer.appendChild(sessionLink);
            });
        };
    </script>
</body>
</html>
