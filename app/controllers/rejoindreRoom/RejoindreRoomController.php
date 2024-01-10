<?php

namespace app\controllers\rejoindreRoom;

use app\views\rejoindreRoom\RejoindreRoom as rejoindreRoomView;
class RejoindreRoomController
{
    public function execute():void {
        (new rejoindreRoomView())->show();
    }

    public function validationCode(string $code):void
    {
        if($code == $_SESSION['codeJeu']){
            $_SESSION['codeValide'] = 'vrai';
            header('Location: /inscription');
        } else{
            $_SESSION['erreurCode'] = 'Le code entré n\'est pas le bon';
            header('Location :/rejoindre-room');
        }

    }

}