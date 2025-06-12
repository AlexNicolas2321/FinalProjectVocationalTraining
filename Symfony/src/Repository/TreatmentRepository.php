<?php

namespace App\Repository;

use App\Entity\Treatment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


class TreatmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Treatment::class);
    }

    public function totalOfEachTreatments(): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT t.name,COUNT(*) AS usage_count FROM treatment t
        join appointment a on t.doctor_id = a.doctor_id
        group by t.name
        order by usage_count desc';

        return $conn->executeQuery($sql)->fetchAllAssociative();
    }

    public function mostUsedTreatment(): ?array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT t.name, COUNT(*) AS usage_count FROM appointment a
        JOIN treatment t ON t.doctor_id = a.doctor_id
        GROUP BY t.name
        ORDER BY usage_count DESC
        LIMIT 1';

        return $conn->executeQuery($sql)->fetchAssociative();
    }
}
