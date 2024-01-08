<?php

namespace app\controllers\regles;

use app\views\regles\ReglesJeu as reglesJeuView;

class ReglesJeuController
{
    public function execute(): void {
        (new reglesJeuView())->show();
    }
}