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
            let touteLesQuestions = [];
            let questionIndex = 0;

            window.onload = () => {
                getQuestion();
            };

            function shuffleArray(array) {
                for (let i = array.length - 1; i > 0; i--) {
                    const j = Math.floor(Math.random() * (i + 1));
                    [array[i], array[j]] = [array[j], array[i]];
                }
                return array;
            }

            function getQuestion() {
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
                            throw new Error(`HTTP erreur! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(json => {
                        touteLesQuestions = shuffleArray(json.value);
                        console.log('Questions récupérées (mélangées) :', touteLesQuestions);
                        displayQuestion();
                    })
                    .catch(error => {
                        console.error('Erreur dans l\'exécution de la requête:', error);
                    });
            }



            function displayQuestion() {
                console.log('Affichage de la question.');
                const questionContainer = document.getElementById('question-container');
                const currentQuestion = touteLesQuestions[questionIndex];

                console.log('Current Question:', currentQuestion);
                console.log('Current Question (JSON):', JSON.stringify(currentQuestion, null, 2));

                if (currentQuestion) {
                    const questionMarkup = `
        <div class="question">
            <h2>Question ${questionIndex + 1}</h2>
            <p>${currentQuestion.question}</p>
            <ul>
                <li><input type="radio" name="reponse" value="${currentQuestion.vrai}"> ${currentQuestion.vrai}</li>
                <li><input type="radio" name="reponse" value="${currentQuestion.faux}"> ${currentQuestion.faux}</li>
                <li><input type="radio" name="reponse" value="${currentQuestion.faux2}"> ${currentQuestion.faux2}</li>
            </ul>
        </div>`;
                    questionContainer.innerHTML = questionMarkup;
                    const radioButtons = document.querySelectorAll('input[name="reponse"]');
                    radioButtons.forEach(button => {
                        button.addEventListener('change', () => {
                            questionIndex++;
                            displayQuestion();
                        });
                    });
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
