<?php

namespace config;

error_reporting(E_ERROR | E_PARSE);
use PDO;

class BaseDeDonnee
{
    private static ?PDO $connection = null;

    public static function getConnection(): PDO
    {
        if (self::$connection === null) {
            $config = parse_ini_file('db.ini');
            if ($config === false) {
                echo 'Erreur peut pas lod le file :3';
                die("Error loading configuration file.");
            }
            self::$connection = new PDO($config['dsn'], $config['username'], $config['password']);
        }
        return self::$connection;
    }
    public static function ajouterQuestion($question,$vrai,$faux,$faux2)
    {
        self::getConnection();
        $requete = 'INSERT INTO questions (question, vrai, faux, faux2) VALUES ( ?, ? , ? , ? )';
        $statement = self::$connection->prepare($requete);
        if (!$statement) {
            error_log('Impossible d\'insérer la question');
            return null;
        }
        $statement->execute([$question,$vrai,$faux,$faux2]);
    }
    public static function getQuestion(int $id): ?array
    {
        self::getConnection();
        $requete = 'SELECT * FROM questions WHERE id = ? ';
        $statement = self::$connection->prepare($requete);
        if (!$statement) {
            error_log('Impossible de faire le statement');
            return null;
        }
        $statement->execute([$id]);
        $reponseServeur = $statement->fetch(PDO::FETCH_ASSOC);
        return [$reponseServeur['question'],[$reponseServeur['vrai'],$reponseServeur['faux'],$reponseServeur['faux2']]];
    }
    public static function getTousLesID():?array
    {
        self::getConnection();
        $requete = 'SELECT id FROM questions';
        $statement = self::$connection->prepare($requete);
        if (!$statement) {
            error_log('Impossible de récuperer tous les ID');
            return null;
        }
        $statement->execute();
        $reponseServeur = $statement->fetchAll(PDO::FETCH_COLUMN, 0);
        return $reponseServeur;
    }
    public static function updateScore()
    {
        $requete = 'UPDATE tablejeu SET Score = Score + 1 WHERE Pseudo = ?';
        $statement = self::$connection->prepare($requete);
        if (!$statement) {
            error_log('Impossible d\'effectuer l\'update de score');
            return null;
        }
        $statement->execute([$_SESSION['pseudoJoueur']]);
    }
    public static function resetScore()
    {
        self::getConnection();
        $requete = 'DELETE FROM tablejeu';
        $statement = self::$connection->prepare($requete);
        if (!$statement) {
            error_log('Impossible de supprimer le contenu de la table');
            return null;
        }
        $statement->execute();
    }
    public static function getTableauDesScores(): ?array
    {
        $requete = 'SELECT * FROM tablejeu ORDER BY score DESC ';
        $statement = self::$connection->prepare($requete);
        if (!$statement) {
            error_log('Impossible d\'effectuer la requête pour le tableau des scores');
            return null;
        }
        $statement->execute();
        $reponseServeur = $statement->fetch(PDO::FETCH_ASSOC);
        $tableauDesScores = [$reponseServeur['pseudo'],$reponseServeur['score']];
        return $tableauDesScores;
    }
    public static function getCodeJeuActuel()
    {
        self::getConnection();
        $requete = 'SELECT * FROM CodeJeu';
        $statement = self::$connection->prepare($requete);
        if (!$statement) {
            error_log('Impossible d\'effectuer la requête pour avoir le code de session');
            return null;
        }
        $statement->execute();
        $reponseServeur = $statement->fetch(PDO::FETCH_ASSOC);
        $_SESSION['codeJeu'] = $reponseServeur['codeJeuActuel'];
    }
    public static function miseAJourDuCodeJeu(string $code)
    {
        $requete = 'UPDATE CodeJeu SET codeJeuActuel = ? ';
        $statement = self::$connection->prepare($requete);
        if (!$statement) {
            error_log('Impossible d\'effectuer l\'update du code de Jeu');
            return null;
        }
        $statement->execute([$code]);
    }

    public static function getTouteLesQuestions(): ?array
    {
        self::getConnection();
        $questions = [];
        for ($i = 0; $i < 5; $i++) {
            $requete = 'SELECT * FROM questions';
            $statement = self::$connection->prepare($requete);
            if (!$statement) {
                error_log('Impossible d\'obtenir les questions');
                return null;
            }
            $statement->execute();
            $questions[$i] = $statement->fetchAll(PDO::FETCH_COLUMN, $i);
        }

        return $questions;
    }

    public static function supprimerQuestion($id)
    {
        self::getConnection();
        $requete = 'DELETE FROM questions WHERE id = ?';
        $statement = self::$connection->prepare($requete);
        if (!$statement) {
            error_log('Impossible d\'obtenir les questions');
            return null;
        }
        $statement->execute([$id]);
    }

    public static function modifierQuestion($attribut,$id,$valeur)
    {
        self::getConnection();
        $requete = 'UPDATE questions SET ';
        switch ($attribut){
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
        $statement = self::$connection->prepare($requete);
        if (!$statement) {
            error_log('Impossible de modifier la question');
            return null;
        }
        $statement->execute([$valeur,$id]);
    }
}