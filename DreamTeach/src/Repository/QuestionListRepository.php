<?php

namespace App\Repository;

use App\Entity\QuestionList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method QuestionList|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuestionList|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuestionList[]    findAll()
 * @method QuestionList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionListRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, QuestionList::class);
    }

    // /**
    //  * @return QuestionList[] Returns an array of QuestionList objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?QuestionList
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
