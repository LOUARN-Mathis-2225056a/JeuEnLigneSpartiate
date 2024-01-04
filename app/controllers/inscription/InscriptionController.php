<?php

namespace app\controllers\inscription;

use app\views\inscription\Inscription as inscriptionView;

class InscriptionController
{
    public function execute(): void {
        (new inscriptionView())->show();
    }
}