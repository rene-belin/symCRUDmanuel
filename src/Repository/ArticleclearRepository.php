<?php

namespace App\Repository;

use App\Entity\Articleclear;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Articleclear>
 *
 * @method Articleclear|null find($id, $lockMode = null, $lockVersion = null)
 * @method Articleclear|null findOneBy(array $criteria, array $orderBy = null)
 * @method Articleclear[]    findAll()
 * @method Articleclear[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleclearRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Articleclear::class);
    }

//    /**
//     * @return Articleclear[] Returns an array of Articleclear objects
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

//    public function findOneBySomeField($value): ?Articleclear
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
