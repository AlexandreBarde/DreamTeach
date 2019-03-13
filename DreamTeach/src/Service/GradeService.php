<?php
/**
 * Created by PhpStorm.
 * User: boehmhugo
 * Date: 2019-03-13
 * Time: 10:27
 */

namespace App\Service;

use App\Entity\Grade;
use App\Entity\Student;
use Doctrine\ORM\EntityManager;


class GradeService
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function addGrade(Student $student, Grade $grade){
        $student->setGradeid($grade);
        $this->em->flush();
    }


}