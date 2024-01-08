<?php

namespace app\views\TableauDesScores;

use app\models\ModelePage;

class top10
{
    public function show():void
    {
        ob_start();
        ?>
        <p>aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</p>
        <form method="post">
            <select onchange="redirect()" id="changementTop">
                <option value="1">Afficher le classement global</option>
                <option value="10" selected>Afficher le top 10</option>
                <option value="20">Afficher le top 20</option>
                <option value="50">Afficher le top 50</option>
                <option value="100">Afficher le top 100</option>
                <option value="150">Afficher le top 150</option>
                <option value="200">Afficher le top 200</option>
            </select>
        </form>

        <script>
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
        (new ModelePage('Exemple page', ob_get_clean(), 'exemple'))->show();
    }
}