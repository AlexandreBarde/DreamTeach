<?php

namespace App\Repository;


use App\Entity\Student;
use Doctrine\ORM\EntityRepository;

class SessionParticipantsRepository extends EntityRepository
{
    public function countNbSessionAttendedByUser(Student $student)
    {
        $now=new \DateTime('now');
        $now->format('Y-m-d');
        $qb = $this->createQueryBuilder("s")
            ->select('COUNT(s)')
            ->join('s.sessionid', 'sid')
            ->where('s.studentid = :user')->setParameter('user', $student)
            ->andWhere('sid.date < :now')->setParameter('now', $now);


        return $qb->getQuery()->getSingleScalarResult();
    }
}