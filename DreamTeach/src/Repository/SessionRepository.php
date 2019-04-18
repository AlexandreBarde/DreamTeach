<?php

namespace App\Repository;


use App\Entity\Session;
use App\Entity\Student;
use App\Service\EmailService;
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

    public function searchSession($dateFilter, $subjectFilter = null, $softwareFilter = null)
    {
        $qb = $this->createQueryBuilder("s")
            ->leftJoin('s.subjectid', "ss")
            ->where('s.date >= :date')->setParameter('date', $dateFilter)
            ->andWhere('s.closed = 0');

        if ($subjectFilter) {
            $qb->andWhere('ss.id = :subject');
            $qb->setParameter('subject', $subjectFilter);
        }

        if ($softwareFilter) {
            $qb->andWhere("s.isvirtual = 1");
        }

        return $qb->getQuery()->getResult();
    }

    public function sendMailToParticipantsAfterModifySession(Session $session, $body, $mailer)
    {
        $participants = $session->getStudentid();
        foreach ($participants as $participant) {
            EmailService::sendMail(
                $participant->getEmailaddress(),
                "La séance : ".$session->getName()." a été modifiée",
                $body,
                $mailer
            );
        }
    }
}