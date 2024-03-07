<?php

namespace app\views\TableauDeBord;

use app\controllers\TableauDeBord\TableauDeBord as tableauDeBordController;
use app\models\ModelePage;
use app\models\EnvoyerEmails;

class TableauDeBord {

    public function show(): void
    {
        ob_start();
        if(tableauDeBordController::jeuLance()){
            echo '<label hidden="hidden" id="jeuEstLance">1</label>';
        }else{
            echo '<label hidden="hidden" id="jeuEstLance">0</label>';
        }

        ?>

        <button style="margin-top: 10vw" type="submit" name="creerSalle" value="TableauDeBord" onclick="creerSalle()">CREER UNE SALLE</button>
        <p class="codeJeu">code de jeu actuel<br><label class="code"><?php echo $_SESSION['codeJeu']; ?></label></p>
        <button id="lancerJeu" value="jeuLance" onclick="lancerJeu()">Lancer le jeu</button>
        <button id="stopperJeu" value="jeuPause" onclick="stopperJeu()">Stopper le jeu</button>
        <button id="enregistrerMail" value="enregistrerMail" onclick="enregistrerMail()">Enregistrer les adresses mail</button>
        <button onclick="location.href = '/tableau-de-bord/liste-questions'">Liste des questions</button>
        <button onclick="location.href = '/tableau-de-bord/ajout-questions'">Ajouter des questions</button>
        <button onclick="location.href = '/tableau-de-bord/modifier-questions'">Modifier des questions</button>
        <button onclick="location.href = '/qr-code'">Montrer le QR code</button>

        <script>
            function creerSalle() {
                const data = new URLSearchParams();
                data.append("changerCodeJeu", 'true');


                fetch("/ajax.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    body: data
                })
                    .then(reponseServeur => {
                        if (!reponseServeur.ok) {
                            throw new Error(`HTTP error! status: ${reponseServeur.status}`);
                        }
                        return reponseServeur.json();
                    })
                    .then(json => {
                        const resultEl = document.querySelector('.code');
                        resultEl.textContent = json.value;
                        console.log('Changement du code de jeu')

                        console.log(json);
                    })
                    .catch(error => {
                        console.error('Error in execution of the request:', error);

                    });
            }
        </script>
        <script>
            function lancerJeu() {
                const data = new URLSearchParams();
                data.append("lancerJeu", 'true');


                fetch("/ajax.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    body: data
                })
                    .then(reponseServeur => {
                        if (!reponseServeur.ok) {
                            throw new Error(`HTTP error! status: ${reponseServeur.status}`);
                        }
                        return reponseServeur.json();
                    })
                    .then(json => {
                        console.log('jeu lancé');
                        document.getElementById("stopperJeu").disabled = false;
                        document.getElementById("stopperJeu").style = "background-color: #00CCFF;";
                        document.getElementById("lancerJeu").style = "background-color: #0048C0;";
                        document.getElementById("lancerJeu").disabled = true;
                    })
                    .catch(error => {
                        console.error('Error in execution of the request:', error);

                    });
            }
        </script>

        <script>
            function stopperJeu() {
                const data = new URLSearchParams();
                data.append("arreterJeu", 'true');

                fetch("/ajax.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    body: data
                })
                    .then(reponseServeur => {
                        if (!reponseServeur.ok) {
                            throw new Error(`HTTP error! status: ${reponseServeur.status}`);
                        }
                        return reponseServeur.json();
                    })
                    .then(json => {
                        console.log('jeu stoppé');
                        document.getElementById("lancerJeu").disabled = false;
                        document.getElementById("lancerJeu").style = "background-color: #00CCFF;";
                        document.getElementById("stopperJeu").style = "background-color: #0048C0;";
                        document.getElementById("stopperJeu").disabled = true;
                    })
                    .catch(error => {
                        console.error('Error in execution of the request:', error);

                    });
            }

            window.onload = () => {
                if (document.getElementById("jeuEstLance").innerText == 1) {
                    document.getElementById("stopperJeu").disabled = false;
                    document.getElementById("stopperJeu").style = "background-color: #00CCFF;";
                    document.getElementById("lancerJeu").style = "background-color: #0048C0;";
                    document.getElementById("lancerJeu").disabled = true;
                    console.log('Le jeu est lancé')
                } else {
                    document.getElementById("lancerJeu").disabled = false;
                    document.getElementById("lancerJeu").style = "background-color: #00CCFF;";
                    document.getElementById("stopperJeu").style = "background-color: #0048C0;";
                    document.getElementById("stopperJeu").disabled = true;
                    console.log('Le jeu est stoppé')
                }
            }
        </script>
        <script>
            function enregistrerMail() {
                const data = new URLSearchParams();
                data.append("enregistrerMail", 'true');


                fetch("/ajax.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    body: data
                })
                    .then(reponseServeur => {
                        if (!reponseServeur.ok) {
                            throw new Error(`HTTP error! status: ${reponseServeur.status}`);
                        }
                        return reponseServeur.json();
                    })
                    .then(json => {
                        alert("Email bien enregistrés");

                        console.log(json);
                    })
                    .catch(error => {
                        console.error('Error in execution of the request:', error);

                    });
            }
        </script>
        <?php
        (new ModelePage('Tableau De Bord', ob_get_clean(), 'tableauDeBord'))->show();
    }
}