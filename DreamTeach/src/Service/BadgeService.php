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

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function ajoutBadge(Student $student,Badge $badge) {
        $student->addBadgeid($badge);
        $this->em->flush();
    }

}