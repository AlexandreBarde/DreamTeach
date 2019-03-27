<?php


namespace App\Service;


use App\Entity\Qcm;
use App\Entity\Student;
use Doctrine\ORM\EntityManager;

class QcmService
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function initQcm(Student $student)
    {
        $qcm = new Qcm();
        $qcm->setAuthorId($student);
        $this->em->persist($qcm);
        $this->em->flush();

        return $qcm->getId();
    }
}