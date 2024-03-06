<?php

namespace app\controllers\regles;

use app\views\regles\ReglesPenalites as reglesPenalitesView;

class ReglesPenalites
{
    public function execute():void {
        (new reglesPenalitesView())->show();
    }
}