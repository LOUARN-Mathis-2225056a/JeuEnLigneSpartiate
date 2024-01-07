<?php

namespace app\controllers;
use app\views\TableauDesScores as tableauDesScoresView;
use config\BaseDeDonnee as BDD;
class TableauDesScores
{
    public function execute():void
    {
        (new tableauDesScoresView())->show();
    }

    /**
     * <p>Appelle la fonction <i><b>getTableauDesScores</b></i> de la class BaseDeDonnee</p>
     * @return array|null
     */
    public static function getTableauDesScores():?array
    {
        return BDD::getTableauDesScores();
    }
}