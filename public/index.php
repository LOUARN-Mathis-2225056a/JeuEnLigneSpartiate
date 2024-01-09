<?php

require_once __DIR__ . '/../vendor/autoload.php';

use app\controllers\Login as loginController;
use app\controllers\PageIntrouvable as pageIntrouvableController;
use app\controllers\TableauDeBord\TableauDeBord as tableauDeBordController;
use app\controllers\TableauDeBord\AjoutQuestions as ajoutQuestionsController;
use app\controllers\TableauDeBord\ListeDesQuestions as listeDesQuestionsController;
use app\controllers\TableauDeBord\ModifierQuestions as modifierQuestionsController;
use app\controllers\accueil\AccueilController as accueilController;
use app\controllers\Quizz as quizzController;
use app\controllers\TableauDesScores\TableauDesScores as tableauDesScoresController;
use app\controllers\TableauDesScores\top10 as top10Controller;
use app\controllers\TableauDesScores\top20 as top20Controller;
use app\controllers\TableauDesScores\top50 as top50Controller;
use app\controllers\TableauDesScores\top100 as top100Controller;
use app\controllers\TableauDesScores\top150 as top150Controller;
use app\controllers\TableauDesScores\top200 as top200Controller;


use app\controllers\QRCode as qrcodeController;
use app\controllers\regles\ReglesGeneralesController as reglesGeneralesController;
use app\controllers\regles\ReglesJeuController as reglesJeuController;
use app\controllers\regles\ReglesMateriellesController as reglesMateriellesController;
use app\controllers\regles\ReglesPenalitesController as reglesPenalitesController;

use app\controllers\inscription\Inscription as inscriptionController;

use app\controllers\reglesDuJeu\ReglesDuJeuController as reglesDuJeuController;

use app\controllers\rejoindreRoom\RejoindreRoomController as rejoindreRoomController;

session_start();
const APP_PATH = __DIR__ . '/../app';

\config\BaseDeDonnee::getCodeJeuActuel();

try {
    if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['login'])) {
            (new LoginController())->login($_POST);
        }
    }

    if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['inscriptionJoueur'])) {
            (new inscriptionController())->inscriptionJoueur($_POST);
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
                (new quizzController())->execute();
                break;
            case 'accueil':
                (new accueilController())->execute();
                break;
            case 'scores':
                switch ($route[1]){
                    case "":
                        (new tableauDesScoresController())->execute();
                        break;
                    case "top10":
                        (new top10Controller())->execute();
                        break;
                    case "top20":
                        (new top20Controller())->execute();
                        break;
                    case "top50":
                        (new top50Controller())->execute();
                        break;
                    case "top100":
                        (new top100Controller())->execute();
                        break;
                    case "top150":
                        (new top150Controller())->execute();
                        break;
                    case "top200":
                        (new top200Controller())->execute();
                        break;
                }
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
                        break;
                }
                break;
            case 'inscription':
                (new inscriptionController())->execute();
                break;
            case 'regles-du-jeu':
                (new reglesDuJeuController())->execute();
                break;
            case 'rejoindre-room':
                (new rejoindreRoomController())->execute();
                break;
            case 'qr-code':
                (new qrcodeController())->execute();
                break;
        }
    }
}catch (Exception){

}