<?php

namespace app\models;
use PDO;
class Administrateur
{
    public function __construct(private PDO $connection){}

    public function getAdministrateur(string $email): ?array
    {
        $requete = 'SELECT * FROM admin WHERE email = ?';
        $statement = $this->connection->prepare($requete);
        if (!$statement) {
            error_log('Impossible d\'obtenir les infos sur l\'administrateurs');
            return null;
        }

        $statement->execute([$email]);
        $administrateur = $statement->fetch(PDO::FETCH_ASSOC);

        return $administrateur ?: null;
    }
}