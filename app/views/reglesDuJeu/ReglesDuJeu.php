<?php

namespace app\views\reglesDuJeu;

use app\models\ModelePage;
class ReglesDuJeu
{
    public function show():void {
        ob_start(); ?>

        <label class="titre">LES REGLES DU JEU</label>

        <label>Le but est simple ! <br><br> Il s'agit d'un <label class="motImportant">quizz</label> où vous devez cliquer sur la <label class="motImportant">bonne réponse</label> ! <br><br> Une fois que vous avez cliqué,
            le tireur envoie le palet à toute vitesse dans la réponse choisie.
            <br><br>Faites un <label class="motImportant">maximum</label> de bonnes réponses pour avoir le <label class="motImportant">meilleur score</label> de toute la <label class="motImportant">patinoire</label> !</label>

        <button onclick="window.location.href='../accueil'" class="retour">accueil</button>

        <?php (new ModelePage('Règles du jeu', ob_get_clean(), 'reglesDuJeu'))->show();
    }
}