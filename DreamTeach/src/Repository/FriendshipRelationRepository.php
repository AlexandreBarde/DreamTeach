<?php
/**
 * Created by PhpStorm.
 * User: Arnaud
 * Date: 12/02/2019
 * Time: 17:32
 */

namespace App\Repository;


use App\Entity\Student;
use Doctrine\ORM\EntityRepository;

class FriendshipRelationRepository extends EntityRepository
{
    public function checkIfAreUnknow(Student $student1, Student $student2)
    {
        $qb = $this->createQueryBuilder('f')
            ->select('COUNT(f)')
            ->where('f.student_1 = :student1')->setParameter('student1', $student1)
            ->andWhere('f.student_2 = :student2')->setParameter('student2', $student2)
            ->andWhere('f.is_accepted = 0');

        $qb2 = $this->createQueryBuilder('f')
            ->select('COUNT(f)')
            ->where('f.student_1 = :student2')->setParameter('student2', $student2)
            ->andWhere('f.student_2 = :student1')->setParameter('student1', $student1)
            ->andWhere('f.is_accepted = 0');

        $qb3 = $this->createQueryBuilder('f')
            ->select('COUNT(f)')
            ->where('f.student_1 = :student1')->setParameter('student1', $student1)
            ->andWhere('f.student_2 = :student2')->setParameter('student2', $student2)
            ->andWhere('f.is_accepted = 1');

        $qb4 = $this->createQueryBuilder('f')
            ->select('COUNT(f)')
            ->where('f.student_1 = :student2')->setParameter('student2', $student2)
            ->andWhere('f.student_2 = :student1')->setParameter('student1', $student1)
            ->andWhere('f.is_accepted = 1');


        return $qb->getQuery()->getSingleScalarResult() > 0 || $qb2->getQuery()->getSingleScalarResult(
            ) > 0 || $qb3->getQuery()->getSingleScalarResult() > 0 || $qb4->getQuery()->getSingleScalarResult() > 0;
    }

    public function checkIfNotAccepted(Student $student1, Student $student2)
    {
        $qb = $this->createQueryBuilder('f')
            ->select('COUNT(f)')
            ->where('f.student_1 = :student1')->setParameter('student1', $student1)
            ->andWhere('f.student_2 = :student2')->setParameter('student2', $student2)
            ->andWhere('f.is_accepted = 0');

        $qb2 = $this->createQueryBuilder('f')
            ->select('COUNT(f)')
            ->where('f.student_1 = :student2')->setParameter('student2', $student2)
            ->andWhere('f.student_2 = :student1')->setParameter('student1', $student1)
            ->andWhere('f.is_accepted = 0');

        return $qb->getQuery()->getSingleScalarResult() > 0 || $qb2->getQuery()->getSingleScalarResult() > 0;
    }

    public function checkIfAreFriend(Student $student1, Student $student2)
    {
        $qb = $this->createQueryBuilder('f')
            ->select('COUNT(f)')
            ->where('f.student_1 = :student1')->setParameter('student1', $student1)
            ->andWhere('f.student_2 = :student2')->setParameter('student2', $student2)
            ->andWhere('f.is_accepted = 1');

        $qb2 = $this->createQueryBuilder('f')
            ->select('COUNT(f)')
            ->where('f.student_1 = :student2')->setParameter('student2', $student2)
            ->andWhere('f.student_2 = :student1')->setParameter('student1', $student1)
            ->andWhere('f.is_accepted = 1');

        return $qb->getQuery()->getSingleScalarResult() > 0 || $qb2->getQuery()->getSingleScalarResult() > 0;

    }
}