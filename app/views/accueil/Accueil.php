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
                <label>SPARTIATES</label>
                <label>HOCKEY</label>
                <label>GAME</label>
            </div>
            <button onclick="window.location.href='../rejoindre-room'" >JOUER</button>
            <button onclick="window.location.href='../regles-du-jeu'" class="bouton-regles">REGLES DU JEU</button>
            <button onclick="window.location.href='../regles'" class="bouton-regles">REGLES DU HOCKEY</button>
            <button onclick="window.location.href=''" class="bouton-regles" style="margin-bottom: 20vw">CLASSEMENT</button>
        </div>

        <?php
        (new ModelePage('Page d\'accueil', ob_get_clean(), 'accueil'))->show();
    }
}