<?php

namespace app\controllers\TableauDeBord;
use app\views\TableauDeBord\ListeDesQuestions as listeDesQuestionsViews;
class ListeDesQuestions
{
    public function execute()
    {
        (new listeDesQuestionsViews())->show();
    }
}