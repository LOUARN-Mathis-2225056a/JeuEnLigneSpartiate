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
                . $question[4][$id] . '</p>';
        }
        ?>
        <?php
        (new ModelePage('Questions', ob_get_clean(), 'listeQuestions'))->show();
    }
}