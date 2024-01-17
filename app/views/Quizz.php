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
                        displayQuestion(0);
                    })
                    .catch(error => {
                        console.error('Erreur dans l\'exécution de la requête:', error);
                    });
            }



            async function displayQuestion(score) {
                var newScore = score;
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
                <div class="pseudoScoreDiv">
                    <p id="nomJoueur"><?php echo $_SESSION['joueurPseudo'] ?></p>
                    <h1 id="score">${newScore}</h1>
                </div>
                <h2>Question <label class="numeroQuestion">${questionIndex + 1}</label></h2>
                <p>${currentQuestion.question}</p>
                <div class="cases">
                    <label id="caseReponse1" class="caseReponse">A</label>
                    <label id="caseReponse2" class="caseReponse">B</label>
                    <label id="caseReponse3" class="caseReponse">C</label>
                </div>
                <img id="spriteTireur" src="/assets/ressources/sprites/AttaquantHockey1.png">
                <img id="palet" src="/assets/ressources/sprites/palet.png">
                <ul>
                    <li><label class="lettreReponse">A</label><input id="${shuffledReponses[0]}" type="radio" name="reponse" value="${shuffledReponses[0]}"><label class="reponse" id="reponse1" value="${shuffledReponses[0]}" for="${shuffledReponses[0]}">${shuffledReponses[0]}</label></li>
                    <li><label class="lettreReponse">B</label><input id="${shuffledReponses[1]}" type="radio" name="reponse" value="${shuffledReponses[1]}"><label class="reponse" id="reponse2" value="${shuffledReponses[1]}" for="${shuffledReponses[1]}">${shuffledReponses[1]}</label></li>
                    <li><label class="lettreReponse">C</label><input id="${shuffledReponses[2]}" type="radio" name="reponse" value="${shuffledReponses[2]}"><label class="reponse" id="reponse3" value="${shuffledReponses[2]}" for="${shuffledReponses[2]}">${shuffledReponses[2]}</label></li>
                </ul>
            </div>`;

                    questionContainer.innerHTML = questionMarkup;

                    const radioButtons = document.querySelectorAll('input[name="reponse"]');
                    radioButtons.forEach(button => {
                        button.addEventListener('change', async () => {

                            const palet = document.getElementById("palet");

                            spriteShootingAnimation();
                            await sleepNow(910);

                            const reponseLabel1 = document.createElement('label');
                            reponseLabel1.innerHTML = shuffledReponses[0];
                            const reponseLabel2 = document.createElement('label');
                            reponseLabel2.innerHTML = shuffledReponses[1];
                            const reponseLabel3 = document.createElement('label');
                            reponseLabel3.innerHTML = shuffledReponses[2];

                            if (button.id === reponseLabel1.innerHTML) {
                                palet.style.animation = "paletCas1 0.7s";
                            }
                            else if (button.id === reponseLabel2.innerHTML) {
                                palet.style.animation = "paletCas2 0.7s";
                            }
                            else if (button.id === reponseLabel3.innerHTML) {
                                palet.style.animation = "paletCas3 0.7s";
                            }
                            await sleepNow(1000);

                            verifieReponse(currentQuestion.vrai);
                            if (button.id === currentQuestion.vrai) {
                                const data = new URLSearchParams();
                                data.append("updateScore", document.getElementById('nomJoueur').innerText);


                                fetch("/ajax.php", {
                                    method: "POST",
                                    headers: {
                                        "Content-Type": "application/x-www-form-urlencoded",
                                    },
                                    body: data
                                })
                                    .then(reponse => {
                                        if (!reponse.ok) {
                                            throw new Error(`HTTP error! status: ${reponse.status}`);
                                        }
                                        return reponse.json();
                                    })
                                    .then(json => {
                                        newScore += 100;
                                    })
                                    .catch(error => {
                                        console.error('Error in execution of the request:', error);

                                    });
                            }
                            var time = 1000;
                            await sleepNow(time);
                            questionIndex++;
                            displayQuestion(newScore);
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
                const caseReponse1 = document.getElementById("caseReponse1");
                const caseReponse2 = document.getElementById("caseReponse2");
                const caseReponse3 = document.getElementById("caseReponse3");

                if (reponse1.textContent === reponseVraieLabel.innerHTML) {
                    reponse1.style.backgroundColor= "#017d00";
                    caseReponse1.style.backgroundColor="#017d00";
                } else {
                    reponse1.style.backgroundColor= "#9a0003";
                    caseReponse1.style.backgroundColor="#9a0003";
                }

                if (reponse2.textContent === reponseVraieLabel.innerHTML) {
                    reponse2.style.backgroundColor= "#017d00";
                    caseReponse2.style.backgroundColor="#017d00";
                } else {
                    reponse2.style.backgroundColor= "#9a0003";
                    caseReponse2.style.backgroundColor="#9a0003";
                }

                if (reponse3.textContent === reponseVraieLabel.innerHTML) {
                    reponse3.style.backgroundColor= "#017d00";
                    caseReponse3.style.backgroundColor="#017d00";
                } else {
                    reponse3.style.backgroundColor= "#9a0003";
                    caseReponse3.style.backgroundColor="#9a0003";
                }
            }

            async function spriteShootingAnimation() {
                var tireur = document.getElementById("spriteTireur");

                await sleepNow(100)
                tireur.src = "/assets/ressources/sprites/AttaquantHockey2.png";
                await sleepNow(100);
                tireur.src = "/assets/ressources/sprites/AttaquantHockey3.png";
                await sleepNow(100);
                tireur.src = "/assets/ressources/sprites/AttaquantHockey4.png";
                await sleepNow(100);
                tireur.src = "/assets/ressources/sprites/AttaquantHockey5.png";
                await sleepNow(100);
                tireur.src = "/assets/ressources/sprites/AttaquantHockey6.png";
                await sleepNow(100);
                tireur.src = "/assets/ressources/sprites/AttaquantHockey7.png";
                await sleepNow(80);
                tireur.src = "/assets/ressources/sprites/AttaquantHockey8.png";
                await sleepNow(80);
                tireur.src = "/assets/ressources/sprites/AttaquantHockey9.png";
                await sleepNow(50);
                tireur.src = "/assets/ressources/sprites/AttaquantHockey10.png";
                await sleepNow(50);
                tireur.src = "/assets/ressources/sprites/AttaquantHockey11.png";
                await sleepNow(50);
            }

        </script>

        <?php
        (new ModelePage('Quizz', ob_get_clean(), 'quizz'))->show();
    }
}
?>
