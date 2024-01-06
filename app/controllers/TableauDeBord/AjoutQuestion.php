<?php

namespace app\controllers\TableauDeBord;
use app\views\TableauDeBord\AjoutQuestions as ajoutQuestionsView;
use config\BaseDeDonnee;

class AjoutQuestion
{
    public function execute():void
    {
        if ( isset( $_SESSION['login'] ) ) {
            $_SESSION['ajouterQuestion'] = null;
            (new ajoutQuestionsView())->show();
        }else{
            header('Location: /login');
        }

    }
}