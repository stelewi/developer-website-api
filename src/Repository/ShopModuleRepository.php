<?php

namespace App\Repository;

use App\Entity\ShopModule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ShopModule>
 *
 * @method ShopModule|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShopModule|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShopModule[]    findAll()
 * @method ShopModule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShopModuleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShopModule::class);
    }

//    /**
//     * @return ShopModule[] Returns an array of ShopModule objects
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

//    public function findOneBySomeField($value): ?ShopModule
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
