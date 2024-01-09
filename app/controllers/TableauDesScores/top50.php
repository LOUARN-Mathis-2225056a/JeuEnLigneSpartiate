<?php

namespace app\controllers\TableauDesScores;

use app\views\TableauDesScores\top50 as top50View;

class top50
{
    public function execute():void
    {
        (new top50View())->show();
    }
}