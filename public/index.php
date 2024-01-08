<?php

require_once __DIR__ . '/../vendor/autoload.php';

use app\controllers\Login as loginController;
use app\controllers\PageIntrouvable as pageIntrouvableController;
use app\controllers\TableauDeBord\TableauDeBord as tableauDeBordController;
use app\controllers\TableauDeBord\AjoutQuestions as ajoutQuestionsController;
use app\controllers\TableauDeBord\ListeDesQuestions as listeDesQuestionsController;
use app\controllers\TableauDeBord\ModifierQuestions as modifierQuestionsController;
use app\controllers\accueil\AccueilController as accueilController;
//use app\controllers\Quizz as quizzController;




use app\controllers\regles\ReglesGeneralesController as reglesGeneralesController;
use app\controllers\regles\ReglesJeuController as reglesJeuController;
use app\controllers\regles\ReglesMateriellesController as reglesMateriellesController;
use app\controllers\regles\ReglesPenalitesController as reglesPenalitesController;

session_start();
const APP_PATH = __DIR__ . '/../app';
\config\BaseDeDonnee::getCodeJeuActuel();
try {
    if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['login'])) {
            (new LoginController())->login($_POST);
        }
    }

    if (isset($_SERVER['REQUEST_URI']) && isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'GET') {
        $route = ($_SERVER['REQUEST_URI'] === '/') ? '/' : explode('/', trim($_SERVER['REQUEST_URI'], '/'));

        switch ($route[0]){
            case 'login':
                (new loginController())->execute();
                break;
            case 'tableau-de-bord':
                if(!isset($_SESSION['connecte'])) header('Location: /login');
                switch($route[1]){
                    case '':
                        (new tableauDeBordController())->execute();
                        break;
                    case 'ajout-questions':
                        (new ajoutQuestionsController())->execute();
                        break;
                    case 'liste-questions':
                        (new listeDesQuestionsController())->execute();
                        break;
                    case 'modifier-questions':
                        (new modifierQuestionsController())->execute();
                }
                break;

            case $_SESSION['codeJeu']:
                //(new quizzController())->execute();
                echo 'cest la page jeu prime';
                break;
            case 'accueil':
                (new accueilController())->execute();
                break;
            default:
                (new pageIntrouvableController())->execute();
                break;
            case 'regles': //premier "/"
                switch ($route[1]){ // deuxième "/"
                    case 'generales': // url = [addresse-site.com]/regles/generales
                        (new reglesGeneralesController())->execute();
                        break;
                    case 'jeu': // regles/jeu
                        (new reglesJeuController())->execute();
                        break;
                    case 'materielles': // etc...
                        (new reglesMateriellesController())->execute();
                        break;
                    case 'penalites':
                        (new reglesPenalitesController())->execute();
                        break;
                    case '':
                        header('Location: /regles/generales');

                }
        }
    }
}catch (Exception){

}