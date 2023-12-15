<?php

require_once __DIR__ . '/../vendor/autoload.php';
use app\controllers\Login as loginController;
session_start();
echo "feur originel";
try {
//    if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
//        if (isset($_POST['login'])) {
//            echo "feur";
//            (new LoginController())->login($_POST);
//        }
//    }
    if (isset($_SERVER['REQUEST_URI']) && isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'GET') {
        $route = ($_SERVER['REQUEST_URI'] === '/') ? '/' : explode('/', trim($_SERVER['REQUEST_URI'], '/'));

        switch ($route[0]){
            case 'login':
                echo "feur en second";
                (new loginController())->execute();
                break;
        }
    }
}catch (Exception){

}