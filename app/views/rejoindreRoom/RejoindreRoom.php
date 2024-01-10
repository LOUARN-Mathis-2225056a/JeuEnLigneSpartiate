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
            <button type="submit" name="validationCode" value="validationCode">Rejoindre</button>
        </form>
        <?php if(isset($_SESSION['erreurCode'])){
            echo $_SESSION['erreurCode'];
            unset($_SESSION['erreurCode']);
        }?>

        <?php (new ModelePage('Rejoindre une room', ob_get_clean(), 'rejoindreRoom'))->show();
    }
}