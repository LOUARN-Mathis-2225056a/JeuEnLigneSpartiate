<?php

namespace app\controllers\Login;

use app\models\Administrateur;
use app\models\BaseDeDonnee as BDD;
use app\views\Login as loginView;
use PDO;

class Login
{
    public function execute():void
    {
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
            header('Location: /tableau-de-bord');
            exit();
        }
        $email = htmlspecialchars($postData['email']);
        $mdp = htmlspecialchars($postData['mdp']);
        $admin = new Administrateur($this->PDO);
        if (!empty($email) && !empty($mdp))
        {
            $adminData = $admin->getAdministrateur($email);
            if ($adminData !== null)
            {
                if (password_verify($mdp, $adminData['mdp']))
                {
                    $_SESSION['email'] = $adminData['email'];
                    $_SESSION['mdp'] = $adminData['mdp'];
                    $_SESSION['connecte'] = true;
                    header('Location: /tableau-de-bord');
                    exit();
                } else {
                    $errorMessage = 'Votre mot de passe est incorrect...';
                    $_SESSION['errorMessage'] = $errorMessage;
                    echo $mdp;
                    echo '\n' . password_hash($mdp, PASSWORD_BCRYPT);
                    header('Location: /login');
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