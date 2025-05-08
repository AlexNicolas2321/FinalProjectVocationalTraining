<?php

namespace App\Repository;

use App\Entity\Speciality;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


class SpecialityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Speciality::class);
    }

    public function specialities_id_and_name (): array{
        return $this->createQueryBuilder('s')
        ->select('s.id', 's.name') 
        ->getQuery()
        ->getArrayResult(); 
    }
}
