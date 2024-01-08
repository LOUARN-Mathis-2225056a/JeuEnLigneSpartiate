<?php

namespace app\controllers;
use app\views\Quizz as quizzView;
class Quizz
{
    public function execute()
    {
        (new quizzView())->show();
    }
}