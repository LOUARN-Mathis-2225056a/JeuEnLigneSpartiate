<?php

namespace app\views\TableauDeBord;

use app\models\ModelePage;
use app\controllers\TableauDeBord\TableauDeBord;
class ListeDesQuestions
{
    public function show():void
    {
        ob_start();
        $question = TableauDeBord::getTouteLesQuestions();
        ?>
        <div class="pageContent">
        <?php for ($id = 0; $id < sizeof($question); $id++) { ?>
            <div class="question">
                <div class="ligne">
                    <label>ID</label> <label class="contenuQuestion"><?php echo wordwrap($question[$id]['id'], 20, '<br>', true) ?></label>
                </div>
                <div class="ligne">
                    <label class="motQuestion">QUESTION</label> <label class="contenuQuestion"><?php echo wordwrap($question[$id]['question'], 20, '<br>', true) ?></label>
                </div>
                <div class="ligne">
                    <label class="motVrai">VRAI</label> <label class="contenuQuestion"> <?php echo wordwrap($question[$id]['vrai'], 20, '<br>', true) ?></label>
                </div>
                <div class="ligne">
                    <label class="motFaux">FAUX 1</label> <label class="contenuQuestion"> <?php echo wordwrap($question[$id]['faux'], 20, '<br>', true) ?></label>
                </div>
                <div class="ligne">
                    <label class="motFaux">FAUX 2</label> <label class="contenuQuestion"> <?php echo wordwrap($question[$id]['faux2'], 20, '<br>', true) ?></label>
                </div>
                <button class="supprimerQuestion" id="<?= $question[$id]['id'] ?>" onclick="doAjaxRequest(this)">supprimer la question</button>
            </div> <?php
        } ?>
        </div>
        <button onclick="window.location.href='../tableau-de-bord'" class="retour">retour</button>
        <script>
            function doAjaxRequest(button, id) {
                const buttonValue = button.value;
                const data = new URLSearchParams();
                data.append("supprimerQuestion", button.id);

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
                        alert("question " + button.id + " supprimée");
                        console.log(json); // Here you can process the JSON response
                        location.reload();
                    })
                    .catch(error => {
                        console.error('Error in execution of the request:', error);

                    });
            }
        </script>
        <?php
        (new ModelePage('Questions', ob_get_clean(), 'listeQuestions'))->show();
    }
}