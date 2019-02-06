<?php

namespace App\Controller;


use App\Entity\School;
use App\Entity\Student;
use App\Entity\Training;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class StudentController
 * @package App\Controller
 * @Route("/accueil")
 * @IsGranted("ROLE_USER")
 */
class StudentController extends AbstractController
{
    /**
     * @Route("/", name="default_student_connected")
     */

    public function homeStudentAction()
    {
        die('test');
    }

    /**
     * @Route("/profil/{student}", name="student_profile")
     */

    public function studentProfileAction(Student $student)
    {
        $user = $this->getDoctrine()->getRepository(Student::Class)->find($student);
        $userTraining = $this->getDoctrine()->getRepository(Training::class)->findOneBy(
            [
                "id" => $user->getTrainingid(),
            ]
        );

        $schoolUser = $this->getDoctrine()->getRepository(School::class)->findOneBy([
            "id" => $userTraining->getSchoolid(),
        ]);
        return $this->render(
            "viewProfile.html.twig",
            [
                "user" => $user,
                "userTraining" => $userTraining,
                "schoolUser" => $schoolUser,
            ]
        );

    }
}