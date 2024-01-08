<?php

namespace app\views\reglesDuJeu;

use app\models\ModelePage;
class ReglesDuJeu
{
    public function show():void {
        ob_start(); ?>

        <label class="titre">LES REGLES DU JEU</label>

        <label>les nigga les nigga les nigga les nigga les nigga les nigga</label>

        <button onclick="window.location.href='../accueil'" class="retour">accueil</button>

        <?php (new ModelePage('Règles du jeu', ob_get_clean(), 'reglesDuJeu'))->show();
    }
}