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

            button {
                display: block;
                margin-top: 10px;
            }
        </style>
        <h1>Quiz</h1>
        <form id="quiz-form">
            <div id="question-container">
            </div>
            <button type="submit">Valider</button>
        </form>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let questions = [];

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

                function handleQuizSubmission() {
                    const selectedAnswer = document.querySelector('input[name="reponse"]:checked');

                    if (selectedAnswer) {
                        const userAnswer = selectedAnswer.value;
                        const correctAnswer = questions[questionIndex][2];

                    questionIndex++;
                    if (questionIndex < questions.length) {
                        displayQuestion();
                    } else {
                        alert('Vous avez terminé le quiz !');
                    }
                }

                quizForm.addEventListener('submit', function(event) {
                    event.preventDefault();
                    handleQuizSubmission();
                });

                    displayQuestion();
                });
        </script>

        <script>
            let touteLesQuestions = [];
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
        </script>

        <?php
        (new ModelePage('Quizz', ob_get_clean(), 'quizz'))->show();
    }
}
?>
