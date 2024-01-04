<?php

namespace app\models;

class ModelePage
{
    public function __construct(private string $title,
                                private string $content,
                                private string $stylesheet = ''){}
    public function show(): void
    {
?>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <title> <?= $this->title?></title>
            <link rel="stylesheet" href="/assets/styles/main.css">
            <?php if ($this->stylesheet !== '') { ?>
                <link rel="stylesheet" href="/assets/styles/<?= $this->stylesheet ?>.css">
            <?php } ?>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<!--                <link rel="shortcut icon" type="image/jpg" href="ICI"/> faut remplacer ICI par le chemin vers le logo et aussi enlever ce texte-->
        </head>
        <body>
        <?= $this->content?>
        </body>
        </html>
<?php
    }
}