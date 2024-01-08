<?php

namespace app\controllers\reglesDuJeu;

use app\views\reglesDuJeu\ReglesDuJeu as reglesDuJeuView;

class ReglesDuJeuController
{
    public function execute():void {
        (new reglesDuJeuView())->show();
    }
}