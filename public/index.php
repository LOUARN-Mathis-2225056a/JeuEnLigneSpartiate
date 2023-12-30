<?php

require_once __DIR__ . '/../vendor/autoload.php';
use app\controllers\Login as loginController;
use app\controllers\PageIntrouvable as pageIntrouvableController;
use app\controllers\TableauDeBord as tableauDeBordController;
session_start();
try {
    if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['login'])) {
            echo "feur";
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
                (new tableauDeBordController())->execute();
                break;
            default:
                (new pageIntrouvableController())->execute();
                break;
        }
    }
}catch (Exception){

}