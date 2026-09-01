<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Media Quiz</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .quiz-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 8px;
            background-color: #ffffff;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            height: 600px;
        }
        .progress-container {
            width: 100%;
            height: 10px;
            background-color: #ddd;
            margin-bottom: 20px;
        }
        .progress-bar {
            height: 100%;
            width: 0%;
            background-color: #4caf50;
        }
        .media {
            margin: 20px 0;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 250px;
        }
        .media img, .media video, .media audio {
            max-width: 100%;
            max-height: 100%;
            border-radius: 5px;
        }
        .question {
            font-size: 18px;
            margin-bottom: 20px;
        }
        .options {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 100%;
            flex-grow: 1;
        }
        .options button {
            display: block;
            width: 80%;
            margin: 10px 0;
            padding: 10px;
            font-size: 16px;
            color: #292727;
            background-color: #eaedf1;
            border: solid 2px #dce1e6;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .options button:hover {
            background-color: #b1b4b8;
        }
        .options button.incorrect {
            background-color: rgba(0, 0, 0, 0.1);
        }
        .options button.correct {
            background-color: lightblue;
        }
        .next-button {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            background-color: #28a745;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .next-button:hover {
            background-color: #218838;
        }
        .feedback {
            font-size: 16px;
            margin-top: 20px;
            color: #333333;
        }
    </style>
</head>
<body>

<div class="quiz-container">
    <div class="progress-container">
        <div class="progress-bar" id="progressBar"></div>
    </div>

    <div class="media" id="media"></div>
    <div class="question" id="question">Question will appear here</div>
    <div class="options" id="options"></div>
    <div class="feedback" id="feedback"></div>
    <button class="next-button" id="nextButton" onclick="loadQuestion()">Next Question</button>
</div>

<script>
    const questions = [
        {
            type: "image",
            data: "cake.jpeg", // Image URL
            question: "What is shown in this image?",
            options: ["Gâteau", "Glace", "Grand"],
            answer: 0,
        },
        {
            type: "audio",
            data: "hello-french.mp3", // Audio URL
            question: "What does this sound represent?",
            options: ["Boire", "Bonjour", "Petit"],
            answer: 1,
        },
        {
            type: "video",
            data: "french1.mp4", // Video URL
            question: "What is pronounce in this video?",
            options: ["Le Terk", "Le Tarm", "Le Temps"],
            answer: 2,
        },
        {
            type: "image",
            data: "ger.jpg",
            question: "Thank You?",
            options: ["Facture", "Aller", "Merci"],
            answer: 2,
        },
        {
            type: "image",
            data: "teacher.jpeg", // Image URL
            question: "What is shown in this image?",
            options: ["Professeur", "Glace", "Grand"],
            answer: 0,
        },
    ];

    let currentQuestionIndex = 0;
    let usedQuestions = [];

    function loadQuestion() {
        // Hide feedback and next button
        document.getElementById("feedback").textContent = "";
        document.getElementById("nextButton").style.display = "none";
        clearOptions();

        // Check if 7 questions have been asked
        if (usedQuestions.length >= 4) {
            document.getElementById("question").textContent = "Quiz completed!";
            document.getElementById("options").innerHTML = "";
            
            // Redirect to last.php after a 5-second delay
            setTimeout(() => {
                window.location.href = "last.php";  // Redirect to last.php
            }, 5000); // 5 seconds delay before redirecting
            return;
        }

        // Select a random question that hasn't been used
        let randomIndex;
        do {
            randomIndex = Math.floor(Math.random() * questions.length);
        } while (usedQuestions.includes(randomIndex));

        usedQuestions.push(randomIndex);
        currentQuestionIndex = randomIndex;
        const currentQuestion = questions[currentQuestionIndex];

        // Update media (only if the question type is media)
        const mediaElement = document.getElementById("media");
        mediaElement.innerHTML = ""; // Clear previous media
        if (currentQuestion.type === "image") {
            const img = document.createElement("img");
            img.src = currentQuestion.data;
            img.alt = "Question Media";
            mediaElement.appendChild(img);
        } else if (currentQuestion.type === "audio") {
            const audio = document.createElement("audio");
            audio.src = currentQuestion.data;
            audio.controls = true;
            mediaElement.appendChild(audio);
        } else if (currentQuestion.type === "video") {
            const video = document.createElement("video");
            video.src = currentQuestion.data;
            video.controls = true;
            mediaElement.appendChild(video);
        } else if (currentQuestion.type === "text") {
            mediaElement.innerHTML = ""; // Clear media for text-based question
        }

        // Update question text
        const questionElement = document.getElementById("question");
        questionElement.textContent = currentQuestion.question;

        // Update options
        const optionsElement = document.getElementById("options");
        optionsElement.innerHTML = ""; // Clear previous options
        currentQuestion.options.forEach((option, index) => {
            const button = document.createElement("button");
            button.textContent = option;
            button.onclick = () => checkAnswer(index, currentQuestion);
            optionsElement.appendChild(button);
        });

        // Update progress bar
        const progress = (usedQuestions.length / 7) * 100;
        document.getElementById("progressBar").style.width = progress + "%";
    }

    function checkAnswer(selectedIndex, currentQuestion) {
        const optionsElement = document.getElementById("options");
        const feedbackElement = document.getElementById("feedback");

        // Mark the selected answer and correct answer
        Array.from(optionsElement.children).forEach((button, index) => {
            if (index === selectedIndex) {
                button.classList.add(index === currentQuestion.answer ? "correct" : "incorrect");
            } else if (index === currentQuestion.answer) {
                button.classList.add("correct");
            }
        });

        // Provide feedback
        if (selectedIndex === currentQuestion.answer) {
            feedbackElement.textContent = "Correct!";
            feedbackElement.style.color = "#28a745";
        } else {
            feedbackElement.textContent = "Wrong! The correct answer is: " + currentQuestion.options[currentQuestion.answer];
            feedbackElement.style.color = "#dc3545";
        }

        // Show next button
        document.getElementById("nextButton").style.display = "inline-block";
    }

    function clearOptions() {
        const optionsElement = document.getElementById("options");
        Array.from(optionsElement.children).forEach((button) => {
            button.classList.remove("correct", "incorrect");
        });
    }

    // Load the first question when the page loads
    window.onload = loadQuestion;
</script>

</body>
</html>
