<?php

namespace App\Controller;


use App\Entity\Badge;
use App\Entity\School;
use App\Entity\Student;
use App\Entity\Training;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class StudentController
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 */
class StudentController extends AbstractController
{
    /**
     * @Route("/dashboard", name="default_student_connected")
     */

    public function homeStudentAction()
    {
        return $this->render("dashboard.html.twig");
    }

    /**
     * @Route("/mon-profil/", name="student_profile")
     */

    public function studentProfileAction(Request $request)
    {
        return $this->render(
            "viewProfile.html.twig"
        );
    }

    /**
     * @Route("/profil/{student}", name="student_other_profile")
     */
    public function studentOtherProfileAction($student)
    {
        $student = $this->getDoctrine()->getRepository(Student::class)->find($student);
        $user = $this->getUser();
        if (!$student) {
            return $this->redirectToRoute("default_student_connected");
        } elseif ($student == $user) {
            return $this->redirectToRoute('student_profile');
        }

        return $this->render('viewOtherProfile.html.twig');
    }
}