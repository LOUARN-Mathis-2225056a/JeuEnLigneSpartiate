<?php

namespace app\models;
use PDO;
class Administrateur
{
    public function __construct(private PDO $connection){}


    /**
     * <p>Fait un requête pour récupérer les données d'un administrateur dans la BDD et les renvois si il y a quelque chose, sinon renvois null</p>
     * @param string $email
     * @return array|null
     */
    public function getAdministrateur(string $email): ?array
    {
        $requete = 'SELECT * FROM admin WHERE email = ?';
        $declaration = $this->connection->prepare($requete);
        if (!$declaration) {
            error_log('Impossible d\'obtenir les infos sur l\'administrateurs');
            return null;
        }

        $declaration->execute([$email]);
        $administrateur = $declaration->fetch(PDO::FETCH_ASSOC);

        return $administrateur ?: null;
    }
}