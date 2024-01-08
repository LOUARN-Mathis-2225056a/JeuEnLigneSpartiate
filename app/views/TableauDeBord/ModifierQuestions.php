<?php

namespace app\views\TableauDeBord;

use app\models\ModelePage;

class ModifierQuestions
{
    public function show():void
    {
        ob_start();
        ?>
        <label class="titre">Modifier une question</label>
        <label>(laisser le champ vide pour ne rien changer)</label>
        <form method="post">
            <input type="text" name="question" id="identifiant" placeholder="Identifiant de la question">
            <input type="text" name="question" id="question" placeholder="Texte Question">
            <input class="bonneReponse" type="text" name="vrai" id="vrai" placeholder="Réponse juste">
            <input class="mauvaiseReponse" type="text" name="faux" id="faux" placeholder="Réponse fausse">
            <input class="mauvaiseReponse" type="text" name="faux2" id="faux2" placeholder="Deuxième réponse fausse">
            <button type="submit" value="modifierQuestion" onclick="doAjaxRequest(this)">Modifier la question</button>
        </form>
        <p class="messageReponse"></p>
        <button onclick="window.location.href='../tableau-de-bord'" class="retour">retour</button>

        <script>
            function doAjaxRequest(button) {
                // The button is switched off to prevent it from being clicked again.
                button.disabled = true;
                const data = new URLSearchParams();
                const identifiant = document.getElementById('identifiant').value;
                const question = document.getElementById('question').value;
                const vrai = document.getElementById('vrai').value;
                const faux = document.getElementById('faux').value;
                const faux2 = document.getElementById('faux2').value;
                data.append("modifierQuestion", 'true')
                data.append("id", identifiant);
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
                        console.log("données envoyées : ",data);
                    })
                    .catch(error => {
                        console.error('Error in execution of the request:', error);
                        console.log("données envoyées : ",data);
                    });
            }
        </script>
        <?php
        (new ModelePage('Modifier une question', ob_get_clean(), 'modifierQuestion'))->show();
    }
}