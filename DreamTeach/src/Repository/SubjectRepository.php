<?php
/**
 * Created by PhpStorm.
 * User: boehmhugo
 * Date: 2019-02-12
 * Time: 10:55
 */
namespace App\Repository;
use App\Entity\Student;
use App\Entity\Subjectlevel;
use Doctrine\ORM\EntityRepository;
class SubjectRepository extends EntityRepository
{
    //SELECT subject.name FROM subjectlevel, subject,student WHERE student.id = '4' AND subject.id = subjectlevel.subjectID AND subjectlevel.studentID != '4'
    public function markNotInform(Student $student)
    {
        $qb = $this->createQueryBuilder('m')
            ->where('m.id = :user')->setParameter('user', $student->getId())
            ->andWhere('m.id != :user')->setParameter('user',$student->getId());
        return $qb->getQuery()->getResult();
    }
}
