<?php

namespace app\controllers\QRCode;
use app\views\QRCode as qrcodeView;

class QRCode
{
    public function execute()
    {
        (new qrcodeView())->show();
    }
}