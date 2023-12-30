<?php

namespace app\views;

use app\models\ModelePage;

class PageIntrouvable
{
    public function show():void
    {
        ob_start();
        ?>
        <?= "Cette page n'existe pas ¯\_(ツ)_/¯ "?>
        <?php
        (new ModelePage('Error 404', ob_get_clean(), 'pageIntrouvable'))->show();
    }
}