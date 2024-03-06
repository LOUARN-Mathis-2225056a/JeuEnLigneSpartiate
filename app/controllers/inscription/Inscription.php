<?php

namespace app\controllers\inscription;

use app\models\BaseDeDonnee as BDD;
use app\views\inscription\Inscription as inscriptionView;

class Inscription
{
    public function execute(): void
    {

        (new inscriptionView())->show();

    }

    public function inscriptionJoueur($donneePost)
    {
        $connection = BDD::getConnection();
        $joueursActuels = BDD::getTousLesPseudos();
        $pseudo = htmlspecialchars($donneePost['pseudo']);
        $email = htmlspecialchars($donneePost['email']);
        if(in_array($pseudo,$joueursActuels)){
            $_SESSION['erreurInscription'] = 'Pseudo déjà utilisé, veuillez en choisir un autre';
            header('Location: /inscription');
            exit();
        } elseif (strlen($pseudo) < 4 ){
            $_SESSION['erreurInscription'] = 'Le pseudo doit être de 4 caractères minimum';
            header('Location: /inscription');
            exit();
        }
        else{
            $requete = 'INSERT INTO joueurs (pseudo, score, email) VALUES (?, ?, ?)';
            $declaration = $connection->prepare($requete);
            if (!$declaration) {
                error_log('Impossible de créer un joueur');
                return null;
            }
            $declaration->execute([$pseudo,0,$email]);
            $_SESSION['joueurPseudo'] = $pseudo;
            $_SESSION['joueurEmail'] = $email;
            $_SESSION['joueurScore'] = 0;
            $_SESSION['estInscrit'] = 'vrai';
            header('Location: /'.$_SESSION['codeJeu']);
        }

    }
}