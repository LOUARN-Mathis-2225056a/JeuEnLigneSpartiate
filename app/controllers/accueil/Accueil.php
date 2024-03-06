<?php

namespace app\controllers\accueil;

use app\views\accueil\Accueil as accueilView;

class Accueil
{
    public function execute(): void {
        (new accueilView())->show();
    }
}