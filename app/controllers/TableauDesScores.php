<?php

namespace app\controllers;
use app\views\TableauDesScores as tableauDesScoresView;
class TableauDesScores
{
    public function execute():void
    {
        (new tableauDesScoresView())->show();
    }
}