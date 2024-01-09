<?php

namespace app\views\TableauDesScores;

use app\models\ModelePage;

class top200
{
    public function show(): void
    {
        ob_start(); ?>

        <form method="post">
            <select onchange="redirect()" id="changementTop">
                <option value="1">Afficher le classement global</option>
                <option value="10">Afficher le top 10</option>
                <option value="20">Afficher le top 20</option>
                <option value="50">Afficher le top 50</option>
                <option value="100">Afficher le top 100</option>
                <option value="150">Afficher le top 150</option>
                <option value="200" selected>Afficher le top 200</option>
            </select>
        </form>

        <?php echo '<ol>';
        for ($i = 0; $i < 200; $i++) {
            echo '<li> <label id="' . $i . '-nom"></label><label class="scoreJoueur" id="' . $i . '-score"></label></li>';
        }
        ?>
            </ol>
        <style>
            body {
                color: white;
            }
        </style>


        <script>
            window.onload = () => {
                window.setInterval(function (){
                    console.log("hey 2 sec sont passées");
                    changerLesDonnees(200);
                },2000);
                function changerLesDonnees(tailletableau){
                    const data = new URLSearchParams();
                    data.append("tailleTableauDesScores", tailletableau.toString());

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
                            console.log(json);
                            console.log("tableau renvoyé ", json.value)
                            const tableauDesScores = json.value;
                            for (let i = 0; i < 200; i++) {
                                if(tableauDesScores[0][i].toString() == ""){
                                    break;
                                }else {
                                    let nom = document.getElementById(i.toString() + "-nom");
                                    let score = document.getElementById(i.toString() + "-score");
                                    nom.textContent = tableauDesScores[0][i].toString();
                                    score.textContent = tableauDesScores[1][i].toString();
                                }
                            }

                        })
                        .catch(error => {
                            console.error('Error in execution of the request:', error);

                        });
                }

            };

            function redirect() {
                const valeurOptionSelectione = $('#changementTop').find(":selected").val();
                console.log(valeurOptionSelectione, typeof valeurOptionSelectione);
                switch (valeurOptionSelectione) {
                    case '1':
                        location.href = "/scores";
                        break;
                    case '10':
                        location.href = "/scores/top10";
                        break;
                    case '20':
                        location.href = "/scores/top20";
                        break;
                    case '50':
                        location.href = "/scores/top50";
                        break;
                    case '100':
                        location.href = "/scores/top100";
                        break;
                    case '150':
                        location.href = "/scores/top150";
                        break;
                    case '200':
                        location.href = "/scores/top200";
                        break;
                }
            }
        </script>
        <?php
        (new ModelePage('Top 200', ob_get_clean(), 'scores'))->show();
    }
}