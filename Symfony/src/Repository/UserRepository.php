<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function getAllUsers(): array
    {
        // Obtener la conexión DBAL desde el EntityManager
        $conn = $this->getEntityManager()->getConnection();

        // Consulta SQL utilizando GROUP_CONCAT
        $sql = '
            SELECT u.id, u.dni, GROUP_CONCAT(r.name) AS roleNames, GROUP_CONCAT(r.id) AS roleIds
            FROM user u
            INNER JOIN user_role ur ON ur.user_id = u.id
            INNER JOIN role r ON ur.role_id = r.id
            GROUP BY u.id
        ';

        // Ejecutar la consulta y devolver el resultado como array asociativo
        return $conn->executeQuery($sql)->fetchAllAssociative();
    }
}
