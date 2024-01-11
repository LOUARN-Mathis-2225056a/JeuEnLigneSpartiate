<?php

namespace config;

error_reporting(E_ERROR | E_PARSE);

use PDO;


class BaseDeDonnee
{
    private static ?PDO $connection = null;

    /**
     * <p><b>Permet d'ajouter une question avec les réponses associées dans la BDD</b></p>
     * <p>Tous les paramètres sont des string et ont une taille maximale de 500 caractères</p>
     * @param string $question <p>texte représentant la question (colonne <i>"question"</i> dans la BDD) </p>
     * @param string $vrai <p>texte représentant la réponse vraie (colonne <i>"vrai"</i> dans la BDD) </p>
     * @param string $faux <p>texte représentant la première réponse fausse (colonne <i>"faux"</i> dans la BDD) </p>
     * @param string $faux2 <p>texte représentant la deuxième réponse fausse (colonne <i>"faux2"</i> dans la BDD) </p>
     * @return void|null
     *
     */
    public static function ajouterQuestion(string $question, string $vrai, string $faux, string $faux2)
    {
        self::getConnection(); //permet de se connecter à la BDD
        $requete = 'INSERT INTO questions (question, vrai, faux, faux2) VALUES ( ?, ? , ? , ? )';
        $declaration = self::$connection->prepare($requete);
        if (!$declaration) {
            error_log('Impossible d\'insérer la question');
            return null;
        }
        $declaration->execute([$question, $vrai, $faux, $faux2]);
    }

    /**
     * <p>représente la connection avec la BDD, charge les informations de connection dans db.ini</p>
     * @return PDO
     *
     */
    public static function getConnection(): PDO
    {
        if (self::$connection === null) {
            $config = parse_ini_file('db.ini');
            if ($config === false) {
                echo 'Erreur : peut pas load le fichier :3 UwU';
                die("Error loading configuration file.");
            }
            self::$connection = new PDO($config['dsn'], $config['username'], $config['password']);
        }
        return self::$connection;
    }

    /**
     * <p>renvoi la question,et les réponses associées, correspondant à l'ID fournis </p>
     * @param int $id <p>ID de la question qu'on veut obtenir</p>
     * @return array|null <p>le tableau renvoyé est sous cette forme : <b>[question,[réponseVrai,réponseFausse,réponseFausse2]]</b> <br> <b>OU</b> la fonction renvoie <b>null</b> si l'identifiant n'existe pas dans la base de donnée</p>
     */
    public static function getQuestion(int $id): ?array
    {
        if (in_array($id, self::getTousLesID())) {
            self::getConnection();
            $requete = 'SELECT * FROM questions WHERE id = ? ';
            $declaration = self::$connection->prepare($requete);
            if (!$declaration) {
                error_log('Impossible de faire la declaration');
                return null;
            }
            $declaration->execute([$id]);
            $reponseServeur = $declaration->fetch(PDO::FETCH_ASSOC);
            return [$reponseServeur['question'], [$reponseServeur['vrai'], $reponseServeur['faux'], $reponseServeur['faux2']]];
        } else {
            error_log('L\'identifiant donné en paramêtre n\'existe pas dans la base de donnée');
            return null;
        }

    }

    /**
     * <p>Permet d'obtenir un tableau contenant tous les ID de la colonne <i>"id"</i> dans la base de donnée</p>
     * @return array|null <p>un array d'integer simple <b>OU null</b> en cas d'erreur dans la préparation de la declaration </p>
     */
    public static function getTousLesID(): ?array
    {
        self::getConnection();
        $requete = 'SELECT id FROM questions';
        $declaration = self::$connection->prepare($requete);
        if (!$declaration) {
            error_log('Impossible de récuperer tous les ID');
            return null;
        }
        $declaration->execute();
        $reponseServeur = $declaration->fetchAll(PDO::FETCH_COLUMN, 0); // fetchAll avec l'option FETCH_COLUML renvoi un array, il faut spécifier en paramêtre la colone qu'on veut (même si il y en a qu'une)
        return $reponseServeur;
    }

    /**
     * <p>met à jour le score en rajoutant 1 au score actuel. Le pseudo du joueur est obtenue via la virable de session $_SESSION['pseudoJoueur']</p>
     * @return void|null
     */
    public static function updateScore()
    {
        self::getConnection();
        $requete = 'UPDATE joueurs SET score = score + 1 WHERE pseudo = ?';
        $declaration = self::$connection->prepare($requete);
        if (!$declaration) {
            error_log('Impossible d\'effectuer l\'update de score');
            return null;
        }
        $declaration->execute([$_SESSION['pseudoJoueur']]);
    }

    /**
     * <p>supprime toute les données contenues dans la table <i>"joueur"</i></p>
     * @return void|null
     */
    public static function resetScore()
    {
        self::getConnection();
        $requete = 'DELETE FROM joueurs';
        $declaration = self::$connection->prepare($requete);
        if (!$declaration) {
            error_log('Impossible de supprimer le contenu de la table');
            return null;
        }
        $declaration->execute();
    }

    /**
     * <p> renvoi un tableau de tableau sous cette forme : <b>[[tableauDesPseudos],[tableauDesScores]] <br> <b>OU</b> <br> <b>null</b> si la déclaration n'aboutie pas</p>
     * @return array|null
     */
    public static function getTableauDesScores(): ?array
    {
        self::getConnection();
        $tableauDesScores = [];
        for ($i = 0; $i < 2; $i++) {
            $requete = 'SELECT * FROM joueurs ORDER BY score DESC ';
            $declaration = self::$connection->prepare($requete);
            if (!$declaration) {
                error_log('Impossible d\'effectuer la requête pour le tableau des scores');
                return null;
            }
            $declaration->execute();
            $tableauDesScores[$i] = $declaration->fetchAll(PDO::FETCH_COLUMN, $i);
        }
        return $tableauDesScores;
    }

    /**
     * <p>met dans la variable de session <b>$_SESSION['codeJeu']</b> le code de jeu actuellement présent dans la base de donnée (table "codeJeu", colonne "codeJeuActuel"</p>
     * @return void|null
     */
    public static function getCodeJeuActuel()
    {
        self::getConnection();
        $requete = 'SELECT * FROM codeJeu';
        $declaration = self::$connection->prepare($requete);
        if (!$declaration) {
            error_log('Impossible d\'effectuer la requête pour avoir le code de session');
            return null;
        }
        $declaration->execute();
        $reponseServeur = $declaration->fetch(PDO::FETCH_ASSOC);
        $_SESSION['codeJeu'] = $reponseServeur['codeJeuActuel'];
    }

    /**
     * <p>change le code dans la table "codejeu", colonne "codeJeuActuel" </p>
     * @param string $code <p>code qui sera mis dans la base de données avec un taille maximale de 10 (les codes générés sont de taille 4)</p>
     * @return void|null
     */
    public static function miseAJourDuCodeJeu(string $code)
    {
        $requete = 'UPDATE codeJeu SET codeJeuActuel = ? ';
        $declaration = self::$connection->prepare($requete);
        if (!$declaration) {
            error_log('Impossible d\'effectuer l\'update du code de Jeu');
            return null;
        }
        $declaration->execute([$code]);
    }

    /**
     * <p>renvoi un tableau de tableau sous cette forme : <br>
     * [[ID],[Questions],[RéponseVrai],[RéponseFausse],[RéponseFausse2]]</p>
     * @return array|null
     */
    public static function getTouteLesQuestions(): ?array
    {
        self::getConnection();
        $requete = 'SELECT * FROM questions';
        $declaration = self::$connection->prepare($requete);

        if (!$declaration) {
            error_log('Impossible d\'obtenir les questions');
            return null;
        }

        $declaration->execute();
        $questions = $declaration->fetchAll(PDO::FETCH_ASSOC);

        return $questions;
    }


    /**
     * <p>supprime la question d'identifiant correspondant à l'identifiant fourni en paramêtre dans la table "questions"</p>
     * @param int $id
     * @return void|null
     */
    public static function supprimerQuestion(int $id)
    {
        self::getConnection();
        $requete = 'DELETE FROM questions WHERE id = ?';
        $declaration = self::$connection->prepare($requete);
        if (!$declaration) {
            error_log('Impossible d\'obtenir les questions');
            return null;
        }
        $declaration->execute([$id]);
    }

    /**
     * <p>modifie un question de la table question</p>
     * @param int $attribut <p> selon la valeur, la colonne modifiée sera différente : <br> 1-> question <br> 2-> vrai <br> 3-> faux <br> 4-> faux2</p>
     * @param int $id <p> identifiant de la question a modifier</p>
     * @param string $valeur :string <p>contenu qui sera modifier après la requête</p>
     * @return void|null
     */
    public static function modifierQuestion(int $attribut, int $id, string $valeur)
    {
        self::getConnection();
        $requete = 'UPDATE questions SET ';
        switch ($attribut) {
            case 1:
                $requete = $requete . 'question = ? WHERE id = ?';
                break;
            case 2:
                $requete = $requete . 'vrai = ? WHERE id = ?';
                break;
            case 3:
                $requete = $requete . 'faux = ? WHERE id = ?';
                break;
            case 4:
                $requete = $requete . 'faux2 = ? WHERE id = ?';
                break;
            default:
                $_SESSION['erreurModificationQuestion'] = '2';
                break;
        }
        $declaration = self::$connection->prepare($requete);
        if (!$declaration) {
            error_log('Impossible de modifier la question');
            return null;
        }
        $declaration->execute([$valeur, $id]);
    }

    /**
     * <p>Cette fonction retourne tous les pseudos présent dans la base de donnée</p>
     * @return array|null
     */
    public static function getTousLesPseudos(): ?array
    {
        self::getConnection();
        $listePseudo = [];
        $requete = 'SELECT * FROM joueurs ORDER BY score DESC ';
        $declaration = self::$connection->prepare($requete);
        if (!$declaration) {
            error_log('Impossible d\'effectuer la requête pour le tableau des scores');
            return null;
        }
        $declaration->execute();
        $listePseudo = $declaration->fetchAll(PDO::FETCH_COLUMN, 0);
        return $listePseudo;
    }
}