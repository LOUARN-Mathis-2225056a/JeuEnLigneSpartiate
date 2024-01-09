<?php

namespace app\controllers\rejoindreRoom;

use app\views\rejoindreRoom\RejoindreRoom as rejoindreRoomView;
class RejoindreRoomController
{
    public function execute():void {
        (new rejoindreRoomView())->show();
    }
}