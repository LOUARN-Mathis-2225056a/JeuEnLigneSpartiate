<?php

namespace app\controllers\TableauDeBord;
use app\views\TableauDeBord\ModifierQuestion as modifierQuestionView;
class ModifierQuestion
{
    public function execute():void
    {
        $_SESSION['erreurModificationQuestion'] = null;
        (new modifierQuestionView())->show();
    }
}