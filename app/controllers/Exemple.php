<?php

namespace app\controllers;
use app\views\Exemple as ExempleView;
class Exemple
{
    public function execute(): void
    {
        (new ExempleView())->show();
    }
}