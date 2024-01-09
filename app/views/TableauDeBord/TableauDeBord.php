<?php

namespace app\views\TableauDeBord;
use app\models\ModelePage;
class TableauDeBord {

    public function show(): void {
        ob_start();
        ?>

        <button type="submit" name="creerSalle" value="TableauDeBord" onclick="doAjaxRequest(this)">CREER UNE SALLE</button>
        <p class="codeJeu">code de jeu actuel<br><label class="code"><?php echo $_SESSION['codeJeu']; ?></label></p>
        <button onclick="location.href = '/tableau-de-bord/liste-questions'">Liste des questions</button>
        <button onclick="location.href = '/tableau-de-bord/ajout-questions'">Ajouter des questions</button>
        <button onclick="location.href = '/tableau-de-bord/modifier-questions'">Modifier des questions</button>
        <button onclick="location.href = '/qr-code'">Montrer le QR code</button>

        <script>
            function doAjaxRequest(button) {
                // The button is switched off to prevent it from being clicked again.
                button.disabled = true;
                const buttonValue = button.value; // We get the value of the button
                const data = new URLSearchParams();
                data.append("changerCodeJeu", buttonValue);

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
                        // location.reload();
                        const resultEl = document.querySelector('.code');
                        resultEl.textContent = json.value;
                        button.disabled = false;
                        console.log(json); // Here you can process the JSON response
                    })
                    .catch(error => {
                        console.error('Error in execution of the request:', error);

                    });
            }
        </script>
        <?php
        ( new ModelePage( 'Tableau De Bord', ob_get_clean(), 'tableauDeBord' ) )->show();
    }
}