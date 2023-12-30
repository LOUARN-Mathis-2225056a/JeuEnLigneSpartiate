<?php

namespace app\views;

use app\models\ModelePage;

class TableauDeBord
{
    public function show():void
    {
        ob_start();
        ?>
        <?= 'le tableau de bord de fou malade là'?>
        <?php
        (new ModelePage('Tableau De Bord', ob_get_clean(), 'tableauDeBord'))->show();
    }
}