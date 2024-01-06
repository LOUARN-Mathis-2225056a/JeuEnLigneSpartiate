<?php

namespace app\controllers\TableauDeBord;
use app\views\TableauDeBord\ModifierQuestions as modifierQuestionView;
class ModifierQuestions
{
    public function execute():void
    {
        unset($_SESSION['erreurModificationQuestion']);
        unset($_SESSION['modifierQuestion']);
        (new modifierQuestionView())->show();
    }
}