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
            $_SESSION['erreurCode'] = 'CODE INEXISTANT';
            header('Location :/rejoindre-room');
        }

    }

}