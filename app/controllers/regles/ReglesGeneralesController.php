<?php

namespace app\controllers\regles;

use app\views\regles\ReglesGenerales as reglesGeneralesView;

class ReglesGeneralesController
{
    public function execute(): void {
        (new reglesGeneralesView())->show();
    }
}