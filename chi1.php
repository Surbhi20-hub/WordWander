<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chinese Quiz1</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .quiz-container {
            max-width: 800px;
            width: 90%;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
            text-align: center;
            position: relative;
        }

        .progress-bar-container {
            width: 100%;
            height: 10px;
            background-color: #e0e0e0;
            border-radius: 5px;
            margin-bottom: 20px;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            width: 0%;
            background-color: #58cc02;
            transition: width 0.5s;
        }

        .content {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            margin-bottom: 20px;
        }

        .character img {
            width: 100px;
            height: auto;
        }

        .question {
            font-size: 1.5em;
            font-weight: bold;
        }

        .options {
            list-style: none;
            padding: 0;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
        }

        .options button {
            display: inline-block;
            width: 80%;
            padding: 15px;
            font-size: 1em;
            color: #333;
            background-color: #f7f7f7;
            border: 1px solid #ddd;
            border-radius: 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .options button:hover {
            background-color: #f0f0f0;
            border-color: #bbb;
        }

        .options button.correct {
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .options button.incorrect {
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }

        .feedback {
            font-size: 1.2em;
            margin-top: 20px;
            color: #d72c2c;
        }

        .next-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 30px;
            font-size: 1em;
            color: white;
            background-color: #58cc02;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .next-button:hover {
            background-color: #4ba402;
        }

        .quiz-over {
            font-size: 1.5em;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="quiz-container">
        <div class="progress-bar-container">
            <div class="progress-bar" id="progress-bar"></div>
        </div>
        <div class="content">
            <div class="character">
                <img src="ger.jpg" alt="Character">
            </div>
            <div class="question"></div>
        </div>
        <ul class="options"></ul>
        <div class="feedback"></div>
        <button class="next-button" style="display: none;">Next</button>
    </div>

    <script>
        const vocabulary = [
        { word: "Coffee", meaning: "咖啡" },
        { word: "Tea", meaning: "茶" },
        { word: "Water", meaning: "水" },
        { word: "Juice", meaning: "果汁" },
        { word: "Milk", meaning: "牛奶" },
        { word: "Sandwich", meaning: "三明治" },
        { word: "Cake", meaning: "蛋糕" },
        { word: "Ice Cream", meaning: "冰淇淋" },
        { word: "Menu", meaning: "菜单" },
        { word: "Bill", meaning: "账单" },
        { word: "Please", meaning: "请" },
        { word: "Thank you", meaning: "谢谢" },
        { word: "Cat", meaning: "猫" },
        { word: "Dog", meaning: "狗" },
        { word: "School", meaning: "学校" },
        { word: "Book", meaning: "书" },
        { word: "To eat", meaning: "吃" },
        { word: "To drink", meaning: "喝" },
        { word: "To go", meaning: "去" },
        { word: "Big", meaning: "大" },
        { word: "Small", meaning: "小" },
        { word: "Teacher", meaning: "老师" }

        ];

        const questionElement = document.querySelector('.question');
        const optionsElement = document.querySelector('.options');
        const feedbackElement = document.querySelector('.feedback');
        const nextButton = document.querySelector('.next-button');
        const progressBar = document.getElementById('progress-bar');

        let currentQuestion = {};
        let score = 0;
        let questionsAsked = 0;
        const maxQuestions = 10;
        const availableQuestions = [...vocabulary];

        function generateQuestion() {
            if (questionsAsked >= maxQuestions || availableQuestions.length === 0) {
                endQuiz();
                return;
            }

            feedbackElement.textContent = '';
            nextButton.style.display = 'none';
            optionsElement.innerHTML = '';

            
            progressBar.style.width = `${(questionsAsked / maxQuestions) * 100}%`;

            
            const randomIndex = Math.floor(Math.random() * availableQuestions.length);
            currentQuestion = availableQuestions.splice(randomIndex, 1)[0];

            
            const options = vocabulary
                .filter(item => item.meaning !== currentQuestion.meaning)
                .map(item => item.meaning)
                .slice(0, 3);
            options.push(currentQuestion.meaning);
            options.sort(() => Math.random() - 0.5);

            
            questionElement.textContent = ` "${currentQuestion.word}" `;
            options.forEach(option => {
                const button = document.createElement('button');
                button.textContent = option;
                button.addEventListener('click', () => checkAnswer(button, option));
                optionsElement.appendChild(button);
            });

            questionsAsked++;
        }

        function checkAnswer(button, selectedOption) {
            const allButtons = document.querySelectorAll('.options button');
            allButtons.forEach(btn => btn.disabled = true);

            if (selectedOption === currentQuestion.meaning) {
                button.classList.add('correct');
                feedbackElement.textContent = 'Correct! 🎉';
                feedbackElement.style.color = 'green';
                score++;
            } else {
                button.classList.add('incorrect');
                feedbackElement.textContent = `Wrong! The correct answer is "${currentQuestion.meaning}".`;
                feedbackElement.style.color = 'red';
                allButtons.forEach(btn => {
                    if (btn.textContent === currentQuestion.meaning) {
                        btn.classList.add('correct');
                    }
                });
            }

            nextButton.style.display = 'inline-block';
        }

        function endQuiz() {
questionElement.textContent = 'Quiz Over!';
optionsElement.innerHTML = '';
feedbackElement.textContent = `You scored ${score} out of ${maxQuestions}.`;
progressBar.style.width = '100%';

// Automatically redirect to the next page after a delay
setTimeout(() => {
window.location.href = 'session.php'; // Redirect to fren2.php after quiz completion
}, 2000); // 2 seconds delay before redirecting
}


nextButton.addEventListener('click', generateQuestion);


generateQuestion();
    </script>
</body>
</html>


