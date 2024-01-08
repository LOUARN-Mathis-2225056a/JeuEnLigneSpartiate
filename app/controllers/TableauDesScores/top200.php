<?php

namespace app\controllers\TableauDesScores;

use app\views\TableauDesScores\top200 as top200View;

class top200
{
    public function execute():void
    {
        (new top200View())->show();
    }
}