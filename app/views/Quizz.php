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
            <h2>Question <label class="numeroQuestion">${questionIndex + 1}</label></h2>
            <p>${currentQuestion.question}</p>
            <ul>
                <li><input id="vrai" type="radio" name="reponse" value="${currentQuestion.vrai}"><label for="vrai">${currentQuestion.vrai}</label></li>
                <li><input id="faux" type="radio" name="reponse" value="${currentQuestion.faux}"><label for="faux">${currentQuestion.faux}</label></li>
                <li><input id="faux2" type="radio" name="reponse" value="${currentQuestion.faux2}"><label for="faux2">${currentQuestion.faux2}</label></li>
            </ul>
        </div>`;
                    questionContainer.innerHTML = questionMarkup;
                    const radioButtons = document.querySelectorAll('input[name="reponse"]');
                    radioButtons.forEach(button => {
                        button.addEventListener('change', () => {
                            verifieReponse();
                            questionIndex++;
                            displayQuestion();
                        });
                    });
                } else {
                    console.error('Structure de données incorrecte.');
                }
            }

            const sleepNow = (delay) => new Promise((resolve) => setTimeout(resolve, delay))

            async function verifieReponse() {
                const vrai = document.getElementById("vrai");
                const faux = document.getElementById("faux");
                const faux2 = document.getElementById("faux2");
                var time = 10000;

                await sleepNow(time);
                vrai.style.backgroundColor = "green";
                faux.style.backgroundColor = "red";
                faux2.style.backgroundColor = "red";
            }

        </script>

        <?php
        (new ModelePage('Quizz', ob_get_clean(), 'quizz'))->show();
    }
}
?>
