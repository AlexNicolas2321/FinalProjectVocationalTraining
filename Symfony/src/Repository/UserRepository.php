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
        $sql = 'SELECT u.id, u.dni,
       COALESCE(r.first_name, p.first_name, d.first_name) AS first_name,
       COALESCE(r.last_name, p.last_name, d.last_name) AS last_name,
       GROUP_CONCAT(DISTINCT ro.name) AS roleNames,
       GROUP_CONCAT(DISTINCT ro.id) AS roleIds,
       case
        when r.user_id is not null then "receptionist"
         WHEN p.user_id IS NOT NULL THEN "patient"
         WHEN d.user_id IS NOT NULL THEN "doctor"
         ELSE "unknown"
       END AS user_type
        FROM user u
        LEFT JOIN receptionist r ON r.user_id = u.id
        LEFT JOIN patient p ON p.user_id = u.id
        LEFT JOIN doctor d ON d.user_id = u.id
        INNER JOIN user_role ur ON ur.user_id = u.id
        INNER JOIN role ro ON ur.role_id = ro.id
        GROUP BY u.id, u.dni, first_name, last_name

        ';

        // Ejecutar la consulta y devolver el resultado como array asociativo
        return $conn->executeQuery($sql)->fetchAllAssociative();
    }

    public function totalUsers(): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT COUNT(*) AS total_users FROM user';

        return $conn->executeQuery($sql)->fetchAllAssociative();
    }
    
    
}
