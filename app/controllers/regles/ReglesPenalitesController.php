<?php

namespace app\controllers\regles;

use app\views\regles\ReglesPenalites as reglesPenalitesView;

class ReglesPenalitesController
{
    public function execute():void {
        (new reglesPenalitesView())->show();
    }
}