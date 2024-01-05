<?php

namespace app\views;
use app\models\ModelePage;
class TableauDeBord {

    public function show(): void {
        ob_start();
        ?>

        <button type="submit" name="creerSalle" value="TableauDeBord" onclick="doAjaxRequest(this)">CLick creerSalle BTN</button>
        <p class="codeJeu">code de jeu actuel : <?php echo $_SESSION['codeJeu']; ?></p>

        <script>
            function doAjaxRequest(button) {
                // The button is switched off to prevent it from being clicked again.
                button.disabled = true;
                const buttonValue = button.value; // We get the value of the button
                const data = new URLSearchParams();
                data.append("createSomthing", buttonValue);

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
                        const resultEl = document.querySelector('.codeJeu');
                        resultEl.textContent = 'code de jeu actuel : ' + json.value;
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