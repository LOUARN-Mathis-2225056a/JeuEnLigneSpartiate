<?php

namespace app\models;

class Joueur
{
    public int $score;
    public string $nom;

    /**
     * @param int $score
     * @param string $nom
     */
    public function __construct(string $nom, int $score)
    {
        $this->score = $score;
        $this->nom = $nom;
    }


    public static function comparateur(Joueur $a, Joueur $b)
    {
        if ($a->score == $b->score) {
            return 0;
        }
        return ($a->score < $b->score) ? -1 : 1;
    }

    public static function creerTableauDeJoueurs(array $pseudo, array $valeur): array
    {
        $tableauDeJoueur = [];
        for ($i = 0; $i < sizeof($pseudo); $i++) {
            $tableauDeJoueur[$i] = new Joueur($pseudo[$i],intval($valeur[$i]));
        }
        return $tableauDeJoueur;
    }

    public static function trierTableauDeJoueurs(array $tableauJoueur): array
    {
        usort($tableauJoueur, "\\app\\models\\Joueur::comparateur");
        return $tableauJoueur;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function toString():string //utilisé pour le debuggage
    {
        return $this->getNom() . ' a pour score ' . $this->getScore();
    }
}