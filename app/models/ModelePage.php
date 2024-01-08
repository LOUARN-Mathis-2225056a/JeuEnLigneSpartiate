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
        <?php if ($this->title == 'Règles du Hockey sur Glace') { ?>
            <header>
                <button onclick="window.location.href='../../accueil'" class="headerButton">Accueil</button>
                <button onclick="window.location.href='../regles/generales'" class="headerButton">Regles generales</button>
                <button onclick="window.location.href='../regles/materielles'" class="headerButton">Regles materielles</button>
                <button onclick="window.location.href='../regles/jeu'" class="headerButton">Regles de jeu</button>
                <button onclick="window.location.href='../regles/penalites'" class="headerButton">Penalites</button>
            </header>
        <?php }?>
        <?= $this->content?>
        </body>
        </html>
<?php
    }
}