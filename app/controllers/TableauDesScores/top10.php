<?php

namespace app\controllers\TableauDesScores;

use app\views\TableauDesScores\top10 as top10View;

class top10
{
    public function execute():void
    {
        (new top10View())->show();
    }
}