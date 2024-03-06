<?php

require_once __DIR__ . '/../vendor/autoload.php';

use app\controllers\inscription\Inscription as inscriptionController;
use app\controllers\Login\Login as loginController;
use app\controllers\QRCode\QRCode as qrcodeController;
use app\controllers\Quizz\Quizz as quizzController;
use app\controllers\TableauDeBord\AjoutQuestions as ajoutQuestionsController;
use app\controllers\TableauDeBord\ListeDesQuestions as listeDesQuestionsController;
use app\controllers\TableauDeBord\ModifierQuestions as modifierQuestionsController;
use app\controllers\TableauDeBord\TableauDeBord as tableauDeBordController;
use app\controllers\TableauDesScores\TableauDesScores as tableauDesScoresController;
use app\controllers\TableauDesScores\top10 as top10Controller;
use app\controllers\TableauDesScores\top100 as top100Controller;
use app\controllers\TableauDesScores\top150 as top150Controller;
use app\controllers\TableauDesScores\top20 as top20Controller;
use app\controllers\TableauDesScores\top200 as top200Controller;
use app\controllers\TableauDesScores\top50 as top50Controller;
use PageIntrouvable as pageIntrouvableController;


session_start();

\app\models\BaseDeDonnee::getCodeJeuActuel();

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

    if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['validationCode'])) {
            (new RejoindreRoom())->validationCode($_POST['roomCode']);
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
                if(isset($_SESSION['estInscrit']) and $_SESSION['estInscrit'] == 'vrai'){
                    (new quizzController())->execute();
                }else{
                    header('Location: /inscription');
                }

                break;
            case 'accueil':
                (new Accueil())->execute();
                break;
            case '/':
                header('Location: /accueil');
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
                        (new ReglesGenerales())->execute();
                        break;
                    case 'jeu': // regles/jeu
                        (new ReglesJeu())->execute();
                        break;
                    case 'materielles': // etc...
                        (new ReglesMaterielles())->execute();
                        break;
                    case 'penalites':
                        (new ReglesPenalites())->execute();
                        break;
                    case '':
                        header('Location: /regles/generales');
                        break;
                }
                break;
            case 'inscription':
                if (isset($_SESSION['estInscrit']) and $_SESSION['estInscrit'] == 'vrai'){
                    header('Location: /' . $_SESSION['codeJeu']);
                }
                elseif(isset($_SESSION['codeValide']) and $_SESSION['codeValide'] == 'vrai'){
                    (new inscriptionController())->execute();
                }
                else {
                    header('Location: /rejoindre-room');
                }
                break;
            case 'regles-du-jeu':
                (new ReglesDuJeu())->execute();
                break;
            case 'rejoindre-room':
                if(isset($_SESSION['codeValide']) and  $_SESSION['codeValide'] == 'vrai'){
                    header('Location: /inscription');
                }
                else{
                    (new RejoindreRoom())->execute();
                }
                break;
            case 'qr-code':
                (new qrcodeController())->execute();
                break;
            case $_SESSION['codeJeu'] . '-qr-code':
                $_SESSION['codeValide'] = 'vrai';
                header('Location: /inscription');
                break;
        }

    }
}catch (Exception){

}