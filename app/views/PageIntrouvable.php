<?php

namespace app\views;

use app\models\ModelePage;

class PageIntrouvable
{
    public function show():void
    {
        ob_start();
        ?>

        <label class="erreur">ERREUR <label class="erreur2">404</label></label>
        <label>Page introuvable...</label>
        <button onclick="window.location.href='../accueil'" class="retour">ACCUEIL</button>

        <?php
        (new ModelePage('Error pageIntrouvable', ob_get_clean(), 'pageIntrouvable'))->show();
    }
}