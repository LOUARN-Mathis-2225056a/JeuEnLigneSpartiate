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
    public static function getQuestion(int $id): ?array
    {
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
}
