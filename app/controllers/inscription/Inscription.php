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
        $pseudo = $donneePost['pseudo'];
        $email = $donneePost['email'];
        $requete = 'INSERT INTO joueurs (pseudo, score, email) VALUES (?, ?, ?)';
        $declaration = $connection->prepare($requete);
        if (!$declaration) {
            error_log('Impossible de créer un joueur');
            return null;
        }
        $declaration->execute([$pseudo,0,$email]);

        header('Location: /'.$_SESSION['codeJeu']);
    }
}