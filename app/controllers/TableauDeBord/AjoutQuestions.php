<?php

namespace app\controllers\TableauDeBord;
use app\views\TableauDeBord\AjoutQuestions as ajoutQuestionsView;

class AjoutQuestions
{
    public function execute():void
    {
        unset($_SESSION['erreurAjouterQuestion']);
        unset($_SESSION['ajouterQuestion']);
        (new ajoutQuestionsView())->show();
    }
}