<?php

namespace app\controllers;
use app\views\TableauDeBord as tableauDeBordView;
use config\BaseDeDonnee as BDD;
require __DIR__ . '/../../vendor/autoload.php';

class TableauDeBord
{
    public function execute(): void {
        if ( isset( $_SESSION['login'] ) ) {
            $_SESSION['creerSalleReponse'] = '';
            ( new tableauDeBordView() )->show();
        } else {
            header( 'Location: /login' );
        }
    }
    public static function generateurNomAleatoire(int $longueur):string
    {
        $alphabet = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $nom = '';
        for ($i = 0; $i < $longueur; $i++) {
            $nom = $nom . $alphabet[random_int(0,strlen($alphabet))-1];
        }
        return $nom;
    }

    public function creerSalle():void
    {
        BDD::resetScore();
        BDD::miseAJourDuCodeJeu(self::generateurNomAleatoire(4));
    }

}