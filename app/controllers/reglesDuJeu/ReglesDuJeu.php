<?php

namespace app\controllers\reglesDuJeu;

use app\views\reglesDuJeu\ReglesDuJeu as reglesDuJeuView;

class ReglesDuJeu
{
    public function execute():void {
        (new reglesDuJeuView())->show();
    }
}