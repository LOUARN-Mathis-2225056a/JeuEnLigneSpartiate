<?php

namespace app\controllers\regles;

use app\views\regles\ReglesMaterielles as reglesMateriellesView;

class ReglesMaterielles
{
    public function execute():void {
        (new reglesMateriellesView())->show();
    }
}