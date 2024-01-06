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
        for ($id = 0; $id < sizeof($question[0]); $id++) {
            echo '<p>' . $question[0][$id] . ' '
                . $question[1][$id] . ' '
                . $question[2][$id] . ' '
                . $question[3][$id] . ' '
                . $question[4][$id] . '<button id= '. $question[0][$id] . ' onclick="doAjaxRequest(this) "> supprimer la question</button> </p>';
        }
        ?>
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