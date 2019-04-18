<?php
/**
 * Created by PhpStorm.
 * User: boehmhugo
 * Date: 2019-03-11
 * Time: 10:48
 */

namespace App\Service;


use App\Entity\Badge;
use App\Entity\Student;
use Doctrine\ORM\EntityManager;

class BadgeService
{
    protected $em;

    protected $serviceXp;

    public function __construct(EntityManager $em, XpWonService $serviceXp)
    {
        $this->em = $em;
        $this->serviceXp = $serviceXp;

    }

    public function addBadge(Student $student,Badge $badge) {
        $listeBadge = $student->getBadgeid();
        if($listeBadge->contains($badge)) {
            return false;
        }
        $student->addBadgeid($badge);
        $this->em->flush();
        $this->serviceXp->wonXp($student,25);

    }

}