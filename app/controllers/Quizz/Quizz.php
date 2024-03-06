<?php

namespace app\controllers\Quizz;
use app\views\Quizz as quizzView;

class Quizz
{
    public function execute()
    {
        (new quizzView())->show();
    }
}