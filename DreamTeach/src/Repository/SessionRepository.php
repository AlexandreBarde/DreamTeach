<?php
/**
 * Created by PhpStorm.
 * User: Arnaud
 * Date: 11/02/2019
 * Time: 16:13
 */

namespace App\Repository;


use App\Entity\Student;
use Doctrine\ORM\EntityRepository;

class SessionRepository extends EntityRepository
{
    public function countNbSessionOrganizedByUser(Student $student)
    {
        $qb = $this->createQueryBuilder("s")
            ->select('COUNT(s)')
            ->where('s.organizerid = :user')->setParameter('user', $student);

        return $qb->getQuery()->getSingleScalarResult();
    }
}