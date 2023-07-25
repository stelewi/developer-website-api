<?php

namespace App\Repository;

use App\Entity\SwapfestPlayerScore;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SwapfestPlayerScore>
 *
 * @method SwapfestPlayerScore|null find($id, $lockMode = null, $lockVersion = null)
 * @method SwapfestPlayerScore|null findOneBy(array $criteria, array $orderBy = null)
 * @method SwapfestPlayerScore[]    findAll()
 * @method SwapfestPlayerScore[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SwapfestPlayerScoreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SwapfestPlayerScore::class);
    }

//    /**
//     * @return SwapfestPlayerScore[] Returns an array of SwapfestPlayerScore objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SwapfestPlayerScore
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
