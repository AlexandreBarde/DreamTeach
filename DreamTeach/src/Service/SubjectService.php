<?php


namespace App\Service;


use App\Entity\Student;
use App\Entity\Subject;
use App\Entity\Subjectlevel;
use Doctrine\ORM\EntityManager;

class SubjectService
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getSubjectListForSubjectLevelingForUser(Student $student)
    {
        $subjectLevelRepo = $this->em->getRepository(Subjectlevel::class);
        $subjectRepo = $this->em->getRepository(Subject::class);

        $subject = $subjectRepo->findAll();
        $subjectLevelByUser = $subjectLevelRepo->findBy(
            [
                'studentid' => $student,
            ]
        );

        $subjectUserAlreadyMarked = [];
        foreach ($subjectLevelByUser as $a) {
            $subjectUserAlreadyMarked[] = $a->getSubjectid();
        }

        foreach($subjectUserAlreadyMarked as $c){
            $key = array_search($c,$subject);
            if($key!==false){
                unset($subject[$key]);
            }
        }

        return $subject;
    }
}