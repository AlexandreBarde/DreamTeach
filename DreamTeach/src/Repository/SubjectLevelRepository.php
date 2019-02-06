<?php

namespace App\Repository;

use App\Entity\SubjectLevel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SubjectLevel|null find($id, $lockMode = null, $lockVersion = null)
 * @method SubjectLevel|null findOneBy(array $criteria, array $orderBy = null)
 * @method SubjectLevel[]    findAll()
 * @method SubjectLevel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubjectLevelRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SubjectLevel::class);
    }

    // /**
    //  * @return SubjectLevel[] Returns an array of SubjectLevel objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SubjectLevel
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
