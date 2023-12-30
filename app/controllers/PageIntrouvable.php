<?php

namespace app\controllers;
use app\views\PageIntrouvable as PageIntrouvableView;
class PageIntrouvable
{
    public function execute():void
    {
        (new PageIntrouvableView())->show();
    }
}