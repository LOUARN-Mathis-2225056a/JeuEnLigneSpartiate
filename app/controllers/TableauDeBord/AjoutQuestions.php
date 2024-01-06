<?php

namespace app\controllers\TableauDeBord;
use app\views\TableauDeBord\AjoutQuestions as ajoutQuestionsView;
use config\BaseDeDonnee;

class AjoutQuestions
{
    public function execute():void
    {
        unset($_SESSION['ajouterQuestion']);
        (new ajoutQuestionsView())->show();
    }
}