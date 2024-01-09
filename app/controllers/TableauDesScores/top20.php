<?php

namespace app\controllers\TableauDesScores;

use app\views\TableauDesScores\top20 as top20View;

class top20
{
    public function execute():void
    {
        (new top20View())->show();
    }
}