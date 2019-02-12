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
    public function checkIfAreFriends(Student $student1, Student $student2)
    {
        $qb = $this->createQueryBuilder('f')
            ->select('COUNT(f)')
            ->where('f.student_1 = :student1')->setParameter('student1', $student1)
            ->andWhere('f.student_2 = :student2')->setParameter('student2', $student2);

        return $qb->getQuery()->getSingleScalarResult() > 0;
    }
}