<?php

require_once __DIR__ . '/../vendor/autoload.php';
session_start();

try {
    if (isset($_SERVER['REQUEST_URI']) && isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'GET') {
        $route = ($_SERVER['REQUEST_URI'] === '/') ? '/' : explode('/', trim($_SERVER['REQUEST_URI'], '/'));

        switch ($route[0]){
            case 'regles': //premier "/"
                switch ($route[1]){ // deuxième "/"
                    case 'generales': // url = [addresse-site.com]/regles/generales
                        break;
                    case 'jeu': // regles/jeu
                        break;
                    case 'materielles': // etc...
                        break;
                    case 'penalites':
                        break;
                    case '':
                        header('Location: /regles/generales');

                }
        }
    }
}catch (Exception){

}