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
                        touteLesQuestions = json.value;
                        console.log('Questions récupérées :', touteLesQuestions);
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

                if (currentQuestion) {
                    const questionMarkup = `
            <div class="question">
                <h2>Question ${questionIndex + 1}</h2>
                <p>${currentQuestion.questionText}</p>
                <ul>
                    ${currentQuestion.reponses.map(option => `<li><input type="radio" name="reponse" value="${option}"> ${option}</li>`).join('')}
                </ul>
            </div>`;
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
