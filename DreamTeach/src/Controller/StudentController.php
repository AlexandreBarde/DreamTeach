<?php

namespace App\Controller;


use App\Entity\Student;
use App\Entity\Training;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class StudentController
 * @package App\Controller
 * @Route("/dashboard")
 * @IsGranted("ROLE_USER")
 */
class StudentController extends AbstractController
{
    /**
     * @Route("/", name="default_student_connected")
     */

    public function homeStudentAction()
    {
        return $this->render("home.student.html.twig");
    }

    /**
     * @Route("/profil/", name="student_profile")
     */

    public function studentProfileAction()
    {
        $user = $this->getUser();
        $userTraining = $this->getDoctrine()->getRepository(Training::class)->findBy(
            [
                "id" => $user->getTrainingid(),
            ]
        );

        return $this->render(
            "viewProfile.html.twig",
            [
                "user" => $user,
                "userTraining" => $userTraining,
            ]
        );
    }
}