<?php

namespace app\controllers\inscription;

use app\views\inscription\Inscription as inscriptionView;
use config\BaseDeDonnee as BDD;

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
        } else{
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
            header('Location: /'.$_SESSION['codeJeu']);
        }

    }
}