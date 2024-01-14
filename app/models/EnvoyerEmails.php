<?php

namespace app\models;

use config\BaseDeDonnee;

class EnvoyerEmails
{
    public static function envoyerEmails() {

        $joueurs = BaseDeDonnee::getJoueurs();
        $pseudos = $joueurs[0];
        $scores = $joueurs[1];
        $emails = $joueurs[2];

        // Objet du mail
        $sujet = 'Spartiates Quizz - Votre score';

        // Info du mail
        $headers = 'De: Spartiates <spartiatejeu@alwaysdata.net>' . "\r\n";

        for ($i = 0; $i < sizeof($pseudos); $i++) {
            // Le message final du mail
            $message = nl2br('Bonjour ' . $pseudos[$i] . ' !' . "\n"
                . 'Merci pour votre participation au quizz de ce jour durant le match de Hockey sur glace des Spartiates !' . "\n"
                . 'Votre score : ' . $scores[$i] . "\n"
                . 'Votre classement : #' . $i + 1 . "\n"
                . 'Félicitations et à bientôt dans notre patinoire !');
            mail($emails[$i], $sujet, $message, $headers);
        }
    }
}