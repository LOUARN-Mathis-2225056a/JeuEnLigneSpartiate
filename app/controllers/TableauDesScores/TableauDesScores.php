<?php

namespace app\controllers\TableauDesScores;
require_once __DIR__ . '/../../../vendor/autoload.php';

use app\models\Joueur;
use app\views\TableauDesScores\TableauDesScores as tableauDesScoresView;
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
        $tableauRaw = BDD::getTableauDesScores();
        return Joueur::trierTableauDeJoueurs(Joueur::creerTableauDeJoueurs($tableauRaw[0],$tableauRaw[1]));
    }

}