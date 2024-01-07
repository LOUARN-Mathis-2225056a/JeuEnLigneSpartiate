<?php

namespace app\controllers\accueil;

use app\views\accueil\Accueil as accueilView;

class AccueilController
{
    public function execute(): void {
        (new accueilView())->show();
    }
}