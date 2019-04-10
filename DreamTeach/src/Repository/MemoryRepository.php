<?php

namespace App\Repository;

use App\Entity\Memory;
use App\Entity\Student;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Memory|null find($id, $lockMode = null, $lockVersion = null)
 * @method Memory|null findOneBy(array $criteria, array $orderBy = null)
 * @method Memory[]    findAll()
 * @method Memory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MemoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Memory::class);
    }

    /**
     * @return Student[] Returns an array of Student objects
     */
    public function findBestScoreByStudent()
    {
        return $this->createQueryBuilder('m')
            ->select('m, min(m.time)')
            ->groupBy('m.Student')
            ->orderBy('m.time')
            ->getQuery()
            ->getResult()
            ;
        /*
         SELECT student_id_id, id, min(time)
         from memory
         group by student_id_id;
         */
    }

    // /**
    //  * @return Memory[] Returns an array of Memory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Memory
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
