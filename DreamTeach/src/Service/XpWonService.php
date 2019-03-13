<?php
/**
 * Created by PhpStorm.
 * User: boehmhugo
 * Date: 2019-03-13
 * Time: 10:43
 */

namespace App\Service;

use App\Entity\Student;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\Tests\Fixtures\User;


class XpWonService
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function wonXp(Student $student, int $xpWon){
        $xpBAse = $student->getXpwon();
        $student->setXpwon(($xpWon+$xpBAse));
        $this->em->flush();
    }

}