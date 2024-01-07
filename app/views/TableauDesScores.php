<?php

namespace app\views;

use app\models\ModelePage;

class TableauDesScores
{
    public function show():void
    {
        ob_start();
        echo 'feur';
        ?>
        <?php
        (new ModelePage('Exemple page', ob_get_clean(), 'exemple'))->show();
    }
}