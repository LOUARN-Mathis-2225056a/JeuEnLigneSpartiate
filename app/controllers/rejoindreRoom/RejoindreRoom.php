<?php

namespace app\controllers\rejoindreRoom;

use app\views\rejoindreRoom\RejoindreRoom as rejoindreRoomView;
class RejoindreRoom
{
    public function execute():void {
        (new rejoindreRoomView())->show();
    }

    public function validationCode(string $code)
    {
        if( isset($_SESSION['codeJeu']) and $code == $_SESSION['codeJeu']){
            $_SESSION['codeValide'] = 'vrai';
            header('Location: /inscription');
        } else{
            $_SESSION['erreurCode'] = 'CODE INEXISTANT';
            header('Location: /rejoindre-room');
            exit();
        }


    }

}