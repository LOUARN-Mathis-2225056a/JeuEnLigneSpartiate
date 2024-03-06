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
    public static function getToutLeTableauDesScores():?array
    {
        $tableauRaw = BDD::getTableauDesScores();
        return Joueur::trierTableauDeJoueurs(Joueur::creerTableauDeJoueurs($tableauRaw[0],$tableauRaw[1]));
    }
    public static function getTableauDesScores($taille):?array
    {
        $tableauRaw = BDD::getTableauDesScores();
        $tableauDeJoueur = Joueur::creerTableauDeJoueurs($tableauRaw[0],$tableauRaw[1]);
        $tableauDeJoueur = Joueur::trierTableauDeJoueurs($tableauDeJoueur);
        if(sizeof($tableauDeJoueur) < $taille){
            for ($i = 0; $i < $taille-sizeof($tableauDeJoueur); $i++) {
                $tableauDeJoueur.array_push($tableauDeJoueur,(new Joueur("",0)));
            }
        }
        return array_slice($tableauDeJoueur,0,$taille);
    }

    public static function desObectifierLeTableau(array $tableauDeJoueur):array
    {
        $tableauARendre = [];
        for ($i = 0; $i < sizeof($tableauDeJoueur); $i++) {
            $tableauARendre[0][$i] = $tableauDeJoueur[$i]->nom;
            $tableauARendre[1][$i] = $tableauDeJoueur[$i]->score;
        }
        return $tableauARendre;
    }

}