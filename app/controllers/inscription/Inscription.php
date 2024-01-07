<?php

namespace app\controllers\inscription;

use app\views\inscription\Inscription as inscriptionView;

class Inscription
{
    public function execute(): void {

        (new inscriptionView())->show();

    }
    public function inscriptionJoueur($donneePost){

    }
}