<?php

namespace app\views;

use app\models\ModelePage;

class QRCode
{
    public function show():void
    {
        ob_start();
        echo '<label id="codeJeu" hidden="hidden">'.$_SESSION['codeJeu'] . '</label>'
        ?>
        <div id="qrcode"></div>

        <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
        <script>
            window.onload = () => {
                const codeJeu = document.getElementById("codeJeu").textContent;
                const hauteurEcran = window.innerHeight;
                const largeurEcran = window.innerWidth;
                if(largeurEcran < hauteurEcran){
                    tailleQRcode = largeurEcran;
                }else {tailleQRcode = hauteurEcran}
                new QRCode(document.getElementById("qrcode"), {
                    text: window.location.host + '/' + codeJeu + '-qr-code',
                    width: tailleQRcode*0.80,
                    height: tailleQRcode*0.80
                });
            }

        </script>
        <?php
        (new ModelePage('QR code', ob_get_clean(), 'qrCode'))->show();
    }
}