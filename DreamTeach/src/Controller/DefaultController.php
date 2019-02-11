<?php

namespace App\Controller;


use App\Entity\Student;
use App\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="HomeController")
     */
    public function register(Request $request, UserPasswordEncoderInterface $encode)
    {
        if($this->getUser() !== null)
            return $this->redirectToRoute("default_student_connected");
        $student = new Student();

        $form = $this->createForm(RegisterType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $hash = $encode->encodePassword($student, $student->getPassword());
            $student->setAvatar("");
            $student->setPassword($hash);
            $em = $this->getDoctrine()->getManager();
            $em->persist($student);
            $em->flush();

            return $this->redirectToRoute("HomeController");
        }

        return $this->render(
        "register.html.twig",
        [
            'form' => $form->createView(),
            'user' => $this->getUser(),
        ]
    );
    }

}