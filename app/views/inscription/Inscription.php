<?php

namespace app\views\inscription;

use app\models\ModelePage;

class Inscription
{
    public function show():void
    {
        ob_start();
        ?>
        <form action="" method="post">
            <div>
                <label>PSEUDO</label>
                <input type="text" id="pseudo" name="pseudo" placeholder="Pseudo">
            </div>
            <div>
                <label>EMAIL</label>
                <input type="text" id="email" name="email" placeholder="Email">
            </div>
            <button type="submit" name="next" value="Next">jouer</button>
        </form>
        <?php
        (new ModelePage('Page d\'inscription', ob_get_clean(), 'inscription.css'))->show();
    }
}