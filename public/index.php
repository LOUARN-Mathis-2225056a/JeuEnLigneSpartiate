<?php

require_once __DIR__ . '/../vendor/autoload.php';


use app\controllers\inscription\InscriptionController as inscriptionController;

session_start();

try {
    if (isset($_SERVER['REQUEST_URI']) && isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'GET') {
        $route = ($_SERVER['REQUEST_URI'] === '/') ? '/' : explode('/', trim($_SERVER['REQUEST_URI'], '/'));

        switch ($route[0]){
            case 'inscription':
                (new inscriptionController())->execute();
                break;
        }
    }
}catch (Exception){

}