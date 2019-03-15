<?php

namespace App\Controller;


use App\Entity\School;
use App\Entity\Student;
use App\Form\RegisterSchoolType;
use App\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class DefaultController extends AbstractController
{
    /**
     * @Route("/register", name="HomeController")
     */
    public function register(Request $request, UserPasswordEncoderInterface $encode)
    {
        if($request->get('selectedSchool')) {
            dump($request->get('selectedSchool'));
        }
        if($this->getUser() !== null)
            return $this->redirectToRoute("default_student_connected");
        $student = new Student();
        $school = new School();

        $formRegister = $this->createForm(RegisterType::class, $student);
        $formRegister->handleRequest($request);

        $formSchool = $this->createForm(RegisterSchoolType::class, $school);
        if ($formRegister->isSubmitted() && $formRegister->isValid())
        {
            $hash = $encode->encodePassword($student, $student->getPassword());
            $student->setPassword($hash);
            $em = $this->getDoctrine()->getManager();
            $em->persist($student);
            $em->flush();

            return $this->redirectToRoute("app_login");
        }

        return $this->render(
        "register.html.twig",
        [
            'form' => $formRegister->createView(),
            'formSchool' => $formSchool->createView(),
            'user' => $this->getUser(),
        ]
    );
    }

}