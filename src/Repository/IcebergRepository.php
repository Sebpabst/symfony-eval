<?php

namespace App\Repository;

use App\Entity\Iceberg;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Iceberg>
 */
class IcebergRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Iceberg::class);
    }

    // 
    // @return Iceberg[]
    // public function findEasterEggsIceberg(string $titre): array
    // {
    //     return $this->createQueryBuilder('r') // Un alias est un mot clé pour appeler plus facilement
    //     ->where('r.duration < :duration') // :duration = clé
    //     ->orderBy('r.duration', 'ASC') // Organiser par durée la plus petite à la plus grande
    //     ->setMaxResults(1) // Afficher seulement 1 résultat
    //     ->setParameter('duration', $duration)
    //     ->getQuery()
    //     ->getResultat()
    // }


    
    //    /**
    //     * @return Iceberg[] Returns an array of Iceberg objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('i.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Iceberg
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
