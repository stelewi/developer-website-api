<?php

namespace App\Repository;

use App\Entity\SwapfestPlayer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SwapfestPlayer>
 *
 * @method SwapfestPlayer|null find($id, $lockMode = null, $lockVersion = null)
 * @method SwapfestPlayer|null findOneBy(array $criteria, array $orderBy = null)
 * @method SwapfestPlayer[]    findAll()
 * @method SwapfestPlayer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SwapfestPlayerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SwapfestPlayer::class);
    }

//    /**
//     * @return SwapfestPlayer[] Returns an array of SwapfestPlayer objects
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

//    public function findOneBySomeField($value): ?SwapfestPlayer
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
