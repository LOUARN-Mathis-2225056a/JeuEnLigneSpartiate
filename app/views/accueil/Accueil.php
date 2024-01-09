<?php

namespace app\views\accueil;

use app\models\ModelePage;

class Accueil
{
    public function show(): void {
        ob_start();
        ?>
        <div class="pageContent">
            <img class="logo" src="/assets/ressources/logospartiates.png" alt="logo">
            <div class="titre">
                <div>SPARTIATES</div>
                <div>HOCKEY</div>
                <div>GAME</div>
            </div>
            <button href="lien a mettre vers une autre page" class="boutton-jouer">JOUER</button>
            <button onclick="window.location.href='../regles-du-jeu'" href="lien a mettre vers une autre page" class="boutton-regles">REGLES DU JEU</button>
            <button onclick="window.location.href='../regles'" class="boutton-regles" style="margin-bottom: 20vw">REGLES DU HOCKEY</button>
        </div>

        <?php
        (new ModelePage('Page d\'accueil', ob_get_clean(), 'accueil'))->show();
    }
}