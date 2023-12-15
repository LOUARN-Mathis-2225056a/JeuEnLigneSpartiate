<?php

namespace app\controllers;

use app\models\Administrateur;
use PDO;
use config\BaseDeDonnee as BDD;
use app\views\Login as loginView;
class Login
{
    public function execute():void
    {
        echo "feur controlleuer";
        (new loginView())->show();
    }

    private PDO $PDO;

    public function __construct()
    {
        $this->PDO = BDD::getConnection();
    }

    public function login(array $postData): void
    {
        if (isset($_SESSION['password'])) {
            header('Location: /home');
            exit();
        }
        $email = htmlspecialchars($postData['email']);
        $mdp = htmlspecialchars($postData['mdp']);
        $admin = new Administrateur($this->PDO);
        if (!empty($username) && !empty($mdp))
        {
            $adminData = $admin->getAdministrateur($email);
            if ($adminData !== null)
            {
                if (password_verify($mdp, $adminData['mdp']))
                {
                    $_SESSION['email'] = $adminData['email'];
                    $_SESSION['mdp'] = $adminData['mdp'];
                    header('Location: /accueil');
                    exit();
                } else {
                    $errorMessage = 'Votre mot de passe est incorrect...';
                    $_SESSION['errorMessage'] = $errorMessage;
                    header('Location: /admin');
                    exit();
                }
            } else {
                $errorMessage = 'Adresse email incorrect...';
                $_SESSION['errorMessage'] = $errorMessage;
                header('Location: /login');
                exit();
            }
        } else {
            $errorMessage = 'Veuillez compléter tous les champs...';
            $_SESSION['errorMessage'] = $errorMessage;
            header('Location: /login');
            exit();
        }
    }
}