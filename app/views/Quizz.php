<?php

namespace app\views;

use app\models\ModelePage;
use config\BaseDeDonnee;

class Quizz
{
    public function show(): void
    {
        ob_start();
        ?>
        <style>
            body{
                background: white;
            }
            * {
                font-family: Arial, sans-serif;
                margin: 20px;
                color:black;
            }

            h1 {
                text-align: center;
            }

            form {
                max-width: 500px;
                margin: 0 auto;
            }

            ul {
                list-style: none;
                padding: 0;
            }
        </style>
        <h1>Quiz</h1>
        <form id="quiz-form">
            <div id="question-container">
            </div>
        </form>
        <script>
            window.onload = () => {
                getQuestion();
            }

            function getQuestion(){
                const data = new URLSearchParams();
                data.append("obtenirQuestion", 'true');

                fetch("/ajax.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    body: data
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(json => {
                        touteLesQuestions = json.value;
                    })
                    .catch(error => {
                        console.error('Error in execution of the request:', error);
                    });
            }


            function displayQuestion() {
                const questionContainer = document.getElementById('question-container');
                const currentQuestion = questions[questionIndex];
                const questionMarkup = `
        <h2>Question ${questionIndex + 1}</h2>
        <p>${currentQuestion[0]}</p>
        <ul>
            ${currentQuestion[1].map(option => `<li><input type="radio" name="reponse" value="${option}"> ${option}</li>`).join('')}
        </ul>
    `;
                questionContainer.innerHTML = questionMarkup;
            }


            window.onload = () => {
                getQuestion();
            };
        </script>

        <?php
        (new ModelePage('Quizz', ob_get_clean(), 'quizz'))->show();
    }
}
?>
