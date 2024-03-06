<?php

namespace app\controllers\404 app\controllers\404 app\controllers\404 app\controllers\404 app\controllers\404;
use app\views\PageIntrouvable as PageIntrouvableView;
class PageIntrouvable
{
    public function execute():void
    {
        (new PageIntrouvableView())->show();
    }
}