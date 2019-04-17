<?php


namespace App\Repository;


use App\Entity\Session;
use Doctrine\ORM\EntityRepository;

class MarkingNotationRepository extends EntityRepository
{
    public function getMarkingAmbienceAverage(Session $session)
    {
        $qb = $this->createQueryBuilder("m")
            ->select("AVG(m.markingAmbience)")
            ->where("m.session = :session")->setParameter('session', $session);

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function getMarkingEfficiencyAverage(Session $session)
    {
        $qb = $this->createQueryBuilder("m")
            ->select("AVG(m.markingEfficiency)")
            ->where("m.session = :session")->setParameter('session', $session);

        return $qb->getQuery()->getSingleScalarResult();
    }
}