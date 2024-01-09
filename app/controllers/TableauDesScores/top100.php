<?php

namespace app\controllers\TableauDesScores;

use app\views\TableauDesScores\top10 as top100View;

class top100
{
    public function execute():void
    {
        (new top100View())->show();
    }
}