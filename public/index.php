<?php

require_once __DIR__ . '/../vendor/autoload.php';

use app\controllers\regles\ReglesGeneralesController as reglesGeneralesController;
use app\controllers\regles\ReglesJeuController as reglesJeuController;
use app\controllers\regles\ReglesMateriellesController as reglesMateriellesController;
use app\controllers\regles\ReglesPenalitesController as reglesPenalitesController;

session_start();

try {
     if (isset($_SERVER['REQUEST_URI']) && isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'GET') {
        $route = ($_SERVER['REQUEST_URI'] === '/') ? '/' : explode('/', trim($_SERVER['REQUEST_URI'], '/'));

        switch ($route[0]){
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