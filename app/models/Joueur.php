<?php

namespace app\models;

class Joueur
{
    public int $score;
    public string $nom;

    /**
     * @param int $score <p>score actuel du joueur</p>
     * @param string $nom <p>le pseudo du joueur</p>
     */
    public function __construct(string $nom, int $score)
    {
        $this->score = $score;
        $this->nom = $nom;
    }

    /**
     * <p>comparateur permettant le trie décroissant entre 2 objet joueur par rapport a leur score</p>
     * @param Joueur $a
     * @param Joueur $b
     * @return int
     */
    public static function comparateur(Joueur $a, Joueur $b)
    {
        if ($a->score == $b->score) {
            return 0;
        }
        return ($a->score > $b->score) ? -1 : 1;
    }

    /**
     * <p>créer un tableau d'objet joueur avec deux arrays, 1 avec tous les pseudo et l'autre avec tous les score, en assument que les score correspondant aux pseudo sont aux même index dans les deux arrays</p>
     * @param array $pseudo
     * @param array $valeur
     * @return array
     */
    public static function creerTableauDeJoueurs(array $pseudo, array $valeur): array
    {
        $tableauDeJoueur = [];
        for ($i = 0; $i < sizeof($pseudo); $i++) {
            $tableauDeJoueur[$i] = new Joueur($pseudo[$i],intval($valeur[$i]));
        }
        return $tableauDeJoueur;
    }

    /**
     * <p>cette fonction sert a trier les joueur dans l'ordre décroissant par rapport a leur score (dans le cos où ils ne sont pas bien trié dans la BDD)</p>
     * @param array $tableauJoueur
     * @return array
     */
    public static function trierTableauDeJoueurs(array $tableauJoueur): array
    {
        usort($tableauJoueur, "\\app\\models\\Joueur::comparateur");
        return $tableauJoueur;
    }

    /**
     * <p>retourne le score du joueur</p>
     * @return int
     */
    public function getScore(): int
    {
        return $this->score;
    }

    /**
     * <p>retourne le pseudo du joueur</p>
     * @return string
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * <p>fonction utile pour débugger les joueurs</p>
     * @return string
     */
    public function toString():string
    {
        return $this->getNom() . ' a pour score ' . $this->getScore();
    }
}