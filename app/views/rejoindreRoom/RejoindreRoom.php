<?php

namespace app\views\rejoindreRoom;

use app\models\ModelePage;

class RejoindreRoom
{
    public function show():void {
        ob_start(); ?>

        <form method="post">
            <label>Entrer un code</label>
            <input type="text" id="roomCode" name="roomCode" placeholder="Code de la room">
            <button type="submit" name="rejoindreRoom" value="rejoindreRoom">Rejoindre</button>
        </form>

        <?php (new ModelePage('Rejoindre une room', ob_get_clean(), 'rejoindreRoom'))->show();
    }
}