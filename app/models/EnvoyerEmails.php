<?php

namespace app\models;
require_once __DIR__ . '/../../vendor/autoload.php';
use config\BaseDeDonnee;

class EnvoyerEmails
{
    public static function envoyerEmails()
    {

        $joueurs = BaseDeDonnee::getJoueurs();

        // Objet du mail
        $sujet = 'Spartiates Quizz - Votre score';

        // Info du mail
        $headers = 'De: Spartiates <spartiatejeu@alwaysdata.net>' . "\r\n";

        for ($i = 0; $i < sizeof($joueurs); $i++) {
            // Le message final du mail
            $message = nl2br('Bonjour ' . $joueurs[$i]['pseudo'] . ' !' . "\n"
                . 'Merci pour votre participation au quizz de ce jour durant le match de Hockey sur glace des Spartiates !' . "\n"
                . 'Votre score est : ' . $joueurs[$i]['score'] . "\n"
                . 'Votre classement : #' . $i + 1 . "\n"
                . 'Félicitations et à bientôt dans notre patinoire !');
            mail($joueurs[$i]['email'], $sujet, $message, $headers);
        }
    }
}