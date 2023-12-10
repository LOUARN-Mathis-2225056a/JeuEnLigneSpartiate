<?php

namespace app\views;

use app\models\ModelePage;

class Exemple
{
    public function show():void
    {
        ob_start();
        ?>
<?php
        (new ModelePage('Exemple page', ob_get_clean(), 'exemple.css')) ->$this->show();
    }
}