<?php

namespace app\views\TableauDeBord;

use app\models\ModelePage;

class AjoutQuestions
{
    public function show():void
    {
        ob_start();
        ?>
        <form>
            <label class="title">Saisir la <label class="motQuestion">question</label> :</label>
            <input class="question" type="text" name="question" id="question" placeholder="Question">
            <label class="title">Saisir la <label class="motVrai">bonne</label> reponse :</label>
            <input class="bonneReponse" type="text" name="vrai" id="vrai" placeholder="Bonne réponse">
            <label class="title">Saisir une <label class="motFaux">mauvaise</label> reponse :</label>
            <input class= "mauvaiseReponse" type="text" name="faux" id="faux" placeholder="Réponse fausse">
            <label class="title">une autre <label class="motFaux">mauvaise</label> reponse :</label>
            <input class= "mauvaiseReponse" type="text" name="faux2" id="faux2" placeholder="Réponse fausse">
            <button type="submit" value="ajoutQuestion" onclick="doAjaxRequest(this)">Ajouter la question</button>
        </form>
        <button class="retour" onclick="window.location.href='../tableau-de-bord'">Retour</button>
        <p class="messageReponse"></p>

        <script>
            function doAjaxRequest(button) {
                // The button is switched off to prevent it from being clicked again.
                button.disabled = true;
                const data = new URLSearchParams();
                const question = document.getElementById('question').value;
                const vrai = document.getElementById('vrai').value;
                const faux = document.getElementById('faux').value;
                const faux2 = document.getElementById('faux2').value;
                data.append("ajouterQuestion", 'true')
                data.append("question", question);
                data.append("vrai", vrai);
                data.append("faux", faux);
                data.append("faux2", faux2);

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
                        button.disabled = false;
                        const messageReponse = document.querySelector('.messageReponse');
                        messageReponse.textContent = json.value;
                        console.log(json); // Here you can process the JSON response
                    })
                    .catch(error => {
                        console.error('Error in execution of the request:', error);
                    });
            }
        </script>
        <?php
        (new ModelePage('Ajout Questions', ob_get_clean(), 'ajoutQuestions'))->show();
    }
}