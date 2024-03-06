<?php

namespace app\controllers\rejoindreRoom;

use app\views\rejoindreRoom\RejoindreRoom as rejoindreRoomView;
class RejoindreRoom
{
    public function execute():void {
        (new rejoindreRoomView())->show();
    }


    /**
     * Valide le code de jeu permettant l'accès au jeu
     * @param string $code
     * @return void
     */
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