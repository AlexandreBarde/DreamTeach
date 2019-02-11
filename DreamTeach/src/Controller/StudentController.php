<?php

namespace App\Controller;


use App\Entity\Student;
use App\Entity\Subject;
use Doctrine\Common\Persistence\ObjectManager;
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
            "viewProfile.html.twig", ['user' => $this->getUser()]
        );
    }

    /**
     * @Route("/profil/{uuid_student}", name="student_other_profile")
     */
    public function studentOtherProfileAction($uuid_student)
    {
        $student = $this->getDoctrine()->getRepository(Student::class)->findBy(
            [
                'uuid' => $uuid_student,
            ]
        );
        $user = $this->getUser();
        if (!$student) {
            return $this->redirectToRoute("default_student_connected");
        } elseif ($uuid_student == $user->getUuid()) {
            return $this->redirectToRoute('student_profile');
        }

        return $this->render(
            'viewOtherProfile.html.twig',
            [
                'student' => $student,
            ]
        );
    }
    /**
     * @Route("/createSubject", name="createSubject")
     */
    public function createSubject(Request $request, ObjectManager $manager)
    {
        $subject = new Subject();
        $form = $this->createFormBuilder($subject)
            ->add('name')
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($subject);
            $manager->flush();
            return $this->redirectToRoute("student_profile", ['idStudent' => $this->getUser()->getId()]);

        }

        return $this->render("createSubject.html.twig", ["formSubject" => $form->createView()]);
    }
}