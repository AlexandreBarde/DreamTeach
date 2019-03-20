<?php

namespace App\Controller;


use App\Entity\School;
use App\Entity\Student;
use App\Form\RegisterSchoolType;
use App\Form\RegisterType;
use App\Service\EmailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class DefaultController extends AbstractController
{
    /**
     * @Route("/register", name="HomeController")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encode
     * @param \Swift_Mailer $mailer
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function register(Request $request, UserPasswordEncoderInterface $encode,\Swift_Mailer $mailer)
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

            EmailService::sendMail(
                $student->getEmailaddress(),
                "Inscription à la plateforme DreamTeach",
                $this->renderView(
                    "mail.register.html.twig",
                    ["user" => $student]
                ),
                $mailer);
            
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