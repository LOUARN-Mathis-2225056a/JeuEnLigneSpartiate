<?php

namespace app\views;

use app\models\ModelePage;

class TableauDesScores
{
    public function show():void
    {
        ob_start();
        $_SESSION['tailleTableauDesScores'] = 20;
        ?>
        <ol>
<?php       for ($i = 0; $i < $_SESSION['tailleTableauDesScores']; $i++) { //créer x balise li avec $i allant de 0 a x-1, x = $_SESSION['tailleTableauDesScores'].
                echo '<li> <label class="nomJoueur" id=" ' . $i . '"> '.$i .'nom</label> <label class="scoreJoueur" id="' . $i . '">'.$i .'score</label> </li>'; // <p class="nomJoueur id="x""> <p class="scoreJoueur id="x"">
            }
?>      </ol>

        <div>

        </div>

        <script>

        </script>


        <?php
        (new ModelePage('Tableau des scores', ob_get_clean(), 'tableauDesScores'))->show();
    }
}