<?php

namespace App\Repository;

use App\Entity\Sessioncomment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SessioncommentRepository|null find($id, $lockMode = null, $lockVersion = null)
 * @method SessioncommentRepository|null findOneBy(array $criteria, array $orderBy = null)
 * @method SessioncommentRepository[]    findAll()
 * @method SessioncommentRepository[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SessioncommentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SessioncommentRepository::class);
    }

    // /**
    //  * @return Sessioncomment[] Returns an array of Sessioncomment objects
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
    public function findOneBySomeField($value): ?Sessioncomment
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
