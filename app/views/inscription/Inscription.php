<?php

namespace app\views\inscription;

use app\models\ModelePage;

class Inscription
{
    public function show():void
    {
        ob_start();
        ?>
        <form method="post">
            <div>
                <label>PSEUDO</label>
                <input type="text" id="pseudo" name="pseudo" placeholder="Pseudo">
            </div>
            <div>
                <label>EMAIL</label>
                <input type="email" id="email" name="email" placeholder="Email">
            </div>
            <?php if(isset($_SESSION['erreurInscription'])){
                echo '<p class="erreur">' . $_SESSION['erreurInscription'] . '</p>';
                unset($_SESSION['erreurInscription']);
            }
            ?>
            <button type="submit" name="inscriptionJoueur" value="inscriptionJoueur">jouer</button>
        </form>
        <?php
        (new ModelePage('Page d\'inscription', ob_get_clean(), 'inscription'))->show();
    }
}