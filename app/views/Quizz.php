<?php

namespace app\views;

use app\models\ModelePage;

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
            let currentScore = 0;

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
                    // language=HTML
                    const questionMarkup = `
        <div class="question">
            <div class="pseudoScoreDiv">
                <p id="nomJoueur"><?php echo $_SESSION['joueurPseudo'] ?></p>
                <h1 id="score">${currentScore}</h1>
            </div>
            <h2>Question <label class="numeroQuestion">${questionIndex + 1}</label></h2>
            <p>${currentQuestion.question}</p>
            <img id="palet" src="/assets/ressources/sprites/palet.png">
        </div>`;

                    questionContainer.innerHTML = questionMarkup;

                    const palet = document.getElementById("palet");
                    let isDragging = false;

                    palet.addEventListener("mousedown", (e) => {
                        isDragging = true;
                        palet.style.cursor = "grabbing";
                    });

                    document.addEventListener("mousemove", (e) => {
                        if (isDragging) {
                            const mouseX = e.clientX;
                            const mouseY = e.clientY;

                            palet.style.left = mouseX + "px";
                            palet.style.top = mouseY + "px";
                        }
                    });

                    document.addEventListener("mouseup", () => {
                        isDragging = false;
                        palet.style.cursor = "grab";
                    });

                    const radioButtons = document.querySelectorAll('input[name="reponse"]');
                    radioButtons.forEach(button => {
                        button.addEventListener('change', async () => {
                            await animateShooting(palet);
                            await sleep(1000);
                            checkAnswer(currentQuestion.vrai);
                            questionIndex++;
                            displayQuestion();
                        });
                    });
                } else {
                    console.error('Structure de données incorrecte.');
                }
            }

            const sleep = (delay) => new Promise((resolve) => setTimeout(resolve, delay));

            async function animateShooting(palet) {
                await spriteShootingAnimation(palet, "/assets/ressources/sprites/AttaquantHockey2.png", 100);
                await spriteShootingAnimation(palet, "/assets/ressources/sprites/AttaquantHockey3.png", 100);
                await spriteShootingAnimation(palet, "/assets/ressources/sprites/AttaquantHockey4.png", 100);
                await spriteShootingAnimation(palet, "/assets/ressources/sprites/AttaquantHockey5.png", 100);
                await spriteShootingAnimation(palet, "/assets/ressources/sprites/AttaquantHockey6.png", 100);
                await spriteShootingAnimation(palet, "/assets/ressources/sprites/AttaquantHockey7.png", 80);
                await spriteShootingAnimation(palet, "/assets/ressources/sprites/AttaquantHockey8.png", 80);
                await spriteShootingAnimation(palet, "/assets/ressources/sprites/AttaquantHockey9.png", 50);
                await spriteShootingAnimation(palet, "/assets/ressources/sprites/AttaquantHockey10.png", 50);
                await spriteShootingAnimation(palet, "/assets/ressources/sprites/AttaquantHockey11.png", 50);
            }

            async function spriteShootingAnimation(element, src, delay) {
                element.src = src;
                await sleep(delay);
            }

            function checkAnswer(correctAnswer) {
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
                        currentScore += 100;
                    })
                    .catch(error => {
                        console.error('Error in execution of the request:', error);
                    });
            }
            .catch(error => {
                console.error('Error in execution of the request:', error);
            });
            }

            function verifieReponse(reponseVraie) {
                const reponseVraieLabel = document.createElement('label');
                reponseVraieLabel.innerHTML = reponseVraie;

                const palet = document.getElementById("palet");

                const elementsToRemove = document.querySelectorAll('.reponse, .lettreReponse, .caseReponse');
                elementsToRemove.forEach(element => element.remove());

                const caseReponse = document.createElement('div');
                caseReponse.className = 'caseReponse';
                caseReponse.appendChild(reponseVraieLabel);
                document.getElementById('question-container').appendChild(caseReponse);

                if (palet.getBoundingClientRect().top > caseReponse.getBoundingClientRect().top &&
                    palet.getBoundingClientRect().bottom < caseReponse.getBoundingClientRect().bottom &&
                    palet.getBoundingClientRect().left > caseReponse.getBoundingClientRect().left &&
                    palet.getBoundingClientRect().right < caseReponse.getBoundingClientRect().right) {
                    caseReponse.style.backgroundColor = "#017d00";  // palet inside the target
                } else {
                    caseReponse.style.backgroundColor = "#9a0003";  // palet outside the target
                }
            }

            function spriteShootingAnimation() {
                const tireur = document.getElementById("spriteTireur");

                sleep(100).then(() => tireur.src = "/assets/ressources/sprites/AttaquantHockey2.png");
                sleep(100).then(() => tireur.src = "/assets/ressources/sprites/AttaquantHockey3.png");
                sleep(100).then(() => tireur.src = "/assets/ressources/sprites/AttaquantHockey4.png");
                sleep(100).then(() => tireur.src = "/assets/ressources/sprites/AttaquantHockey5.png");
                sleep(100).then(() => tireur.src = "/assets/ressources/sprites/AttaquantHockey6.png");
                sleep(100).then(() => tireur.src = "/assets/ressources/sprites/AttaquantHockey7.png");
                sleep(80).then(() => tireur.src = "/assets/ressources/sprites/AttaquantHockey8.png");
                sleep(80).then(() => tireur.src = "/assets/ressources/sprites/AttaquantHockey9.png");
                sleep(50).then(() => tireur.src = "/assets/ressources/sprites/AttaquantHockey10.png");
                sleep(50).then(() => tireur.src = "/assets/ressources/sprites/AttaquantHockey11.png");
            }

        </script>

        <?php
        (new ModelePage('Quizz', ob_get_clean(), 'quizz'))->show();
    }
}
?>
