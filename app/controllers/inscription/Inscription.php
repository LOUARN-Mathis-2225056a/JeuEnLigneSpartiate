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
        $connection = BDD::getConnection(); //ouvre une connection avec la BDD
        $joueursActuels = BDD::getTousLesPseudos(); //permet d'avoir tous les pseudo déjà inscrit
        $pseudo = htmlspecialchars($donneePost['pseudo']);
        $email = htmlspecialchars($donneePost['email']);
        if(in_array($pseudo,$joueursActuels)){ //vérifie si le pseudo n'est pas déjà utilisé
            $_SESSION['erreurInscription'] = 'Pseudo déjà utilisé, veuillez en choisir un autre';
            header('Location: /inscription');
            exit();
        } elseif (strlen($pseudo) < 4 ){ //pseudo doit être d'au moins 4 caractères de long
            $_SESSION['erreurInscription'] = 'Le pseudo doit être de 4 caractères minimum';
            header('Location: /inscription');
            exit();
        }
        else{ // fait le requête pour inscrire le joueur dans la BDD
            $requete = 'INSERT INTO joueurs (pseudo, score, email) VALUES (?, ?, ?)';
            $declaration = $connection->prepare($requete);
            if (!$declaration) {
                error_log('Impossible de créer un joueur');
                return null;
            }
            $declaration->execute([$pseudo,0,$email]);

            //initialise toute les variable de session nécessaire a la bonne utilisation du site
            $_SESSION['joueurPseudo'] = $pseudo;
            $_SESSION['joueurEmail'] = $email;
            $_SESSION['joueurScore'] = 0;
            $_SESSION['estInscrit'] = 'vrai';
            header('Location: /'.$_SESSION['codeJeu']);
            exit();
        }

    }
}