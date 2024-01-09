<?php

namespace app\controllers\TableauDesScores;

use app\views\TableauDesScores\top150 as top150View;

class top150
{
    public function execute():void
    {
        (new top150View())->show();
    }
}