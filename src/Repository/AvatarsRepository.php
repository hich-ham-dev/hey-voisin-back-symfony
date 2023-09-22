<?php

namespace App\Repository;

use App\Entity\Avatars;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Avatars>
 *
 * @method Avatars|null find($id, $lockMode = null, $lockVersion = null)
 * @method Avatars|null findOneBy(array $criteria, array $orderBy = null)
 * @method Avatars[]    findAll()
 * @method Avatars[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AvatarsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Avatars::class);
    }

//    /**
//     * @return Avatars[] Returns an array of Avatars objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Avatars
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
