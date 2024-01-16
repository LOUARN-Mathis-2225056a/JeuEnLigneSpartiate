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



            async function displayQuestion() {
                console.log('Affichage de la question.');
                const questionContainer = document.getElementById('question-container');
                const currentQuestion = touteLesQuestions[questionIndex];

                console.log('Current Question:', currentQuestion);
                console.log('Current Question (JSON):', JSON.stringify(currentQuestion, null, 2));

                if (currentQuestion) {
                    const shuffledReponses = shuffleArray([
                        currentQuestion.vrai,
                        currentQuestion.faux,
                        currentQuestion.faux2
                    ]);

                    // language=HTML
                    const questionMarkup = `
            <div class="question">
                <h1 id="score"><?php echo BaseDeDonnee::getScore()?></h1>
                <h2>Question <label class="numeroQuestion">${questionIndex + 1}</label></h2>
                <p>${currentQuestion.question}</p>
                <ul>
                    <li><input id="${shuffledReponses[0]}" type="radio" name="reponse" value="${shuffledReponses[0]}"><label id="reponse1" value="${shuffledReponses[0]}" for="${shuffledReponses[0]}">${shuffledReponses[0]}</label></li>
                    <li><input id="${shuffledReponses[1]}" type="radio" name="reponse" value="${shuffledReponses[1]}"><label id="reponse2" value="${shuffledReponses[1]}" for="${shuffledReponses[1]}">${shuffledReponses[1]}</label></li>
                    <li><input id="${shuffledReponses[2]}" type="radio" name="reponse" value="${shuffledReponses[2]}"><label id="reponse3" value="${shuffledReponses[2]}" for="${shuffledReponses[2]}">${shuffledReponses[2]}</label></li>
                </ul>
            </div>`;

                    questionContainer.innerHTML = questionMarkup;

                    const radioButtons = document.querySelectorAll('input[name="reponse"]');
                    radioButtons.forEach(button => {
                        button.addEventListener('change', async () => {
                            verifieReponse(currentQuestion.vrai);
                            if (button.id === currentQuestion.vrai) {
                                const data = new URLSearchParams();
                                data.append("updateScore", 'true');


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
                                    .catch(error => {
                                        console.error('Error in execution of the request:', error);

                                    });
                            }
                            var time = 1000;
                            await sleepNow(time);
                            questionIndex++;
                            displayQuestion();
                        });
                    });
                } else {
                    console.error('Structure de données incorrecte.');
                }
            }

            const sleepNow = (delay) => new Promise((resolve) => setTimeout(resolve, delay))

            function verifieReponse(reponseVraie) {
                const reponseVraieLabel = document.createElement('label');
                reponseVraieLabel.innerHTML = reponseVraie;

                const reponse1 = document.getElementById("reponse1");
                const reponse2 = document.getElementById("reponse2");
                const reponse3 = document.getElementById("reponse3");

                if (reponse1.textContent === reponseVraieLabel.innerHTML) {
                    reponse1.style.backgroundColor= "#017d00";
                } else {
                    reponse1.style.backgroundColor= "#9a0003";
                }

                if (reponse2.textContent === reponseVraieLabel.innerHTML) {
                    reponse2.style.backgroundColor= "#017d00";
                } else {
                    reponse2.style.backgroundColor= "#9a0003";
                }

                if (reponse3.textContent === reponseVraieLabel.innerHTML) {
                    reponse3.style.backgroundColor= "#017d00";
                } else {
                    reponse3.style.backgroundColor= "#9a0003";
                }
            }

        </script>

        <?php
        (new ModelePage('Quizz', ob_get_clean(), 'quizz'))->show();
    }
}
?>
