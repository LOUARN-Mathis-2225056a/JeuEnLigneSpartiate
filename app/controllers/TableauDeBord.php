<?php

namespace app\controllers;
use app\views\TableauDeBord as tableauDeBordView;
class TableauDeBord
{
    public function execute(): void
    {
        if($_SESSION['login']) {
            (new tableauDeBordView())->show();
        }else{
            header('Location: /login');
        }
    }
}