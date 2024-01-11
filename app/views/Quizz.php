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
        <h1>Quiz</h1>
        <form id="quiz-form">
            <div id="question-container">
            </div>
        </form>
        <script>
            window.onload = () => {
                getQuestion();
            };

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
                        console.log(touteLesQuestions); // Ajoutez cette ligne pour déboguer
                        displayQuestion(); // Appel à la fonction pour afficher la première question
                    })
                    .catch(error => {
                        console.error('Error in execution of the request:', error);
                    });
            }

            function displayQuestion() {
                const questionContainer = document.getElementById('question-container');
                const currentQuestion = touteLesQuestions[0];

                console.log('Current Question:', currentQuestion);

                if (currentQuestion && Array.isArray(currentQuestion)) {
                    const questionMarkup = `
            <h2>Question 1</h2>
            <p>${currentQuestion[0]}</p>
            <ul>
                ${currentQuestion.slice(1).map(option => `<li><input type="radio" name="reponse" value="${option}"> ${option}</li>`).join('')}
            </ul>`;
                    questionContainer.innerHTML = questionMarkup;
                } else {
                    console.error('Structure de données incorrecte.');
                }
            }

        </script>

        <?php
        (new ModelePage('Quizz', ob_get_clean(), 'quizz'))->show();
    }
}
?>
