<?php

namespace App\Repository;

use App\Entity\Hangman;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Hangman|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hangman|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hangman[]    findAll()
 * @method Hangman[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HangmanRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Hangman::class);
    }

    // /**
    //  * @return Hangman[] Returns an array of Hangman objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Hangman
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
