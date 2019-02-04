<?php

namespace App\Controller;


use App\Entity\School;
use App\Entity\Student;
use App\Entity\Training;
use App\Form\RegisterType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class DefaultController extends AbstractController
{

    /**
     * @Route("/", name="HomeController")
     */
    public function defaultAction()
    {
        return $this->render('base.html.twig');
    }

    /**
     * @Route("/login", name="login")
     */
    public function login()
    {
        $currentUser = $this->getUser();
        if($currentUser === null) return $this->render('login.html.twig');
        else return $this->redirectToRoute('HomeController');
    }

    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request)
    {
        $student = new Student();

        $form = $this->createForm(RegisterType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($student);
            $em->flush();

            return $this->redirectToRoute("HomeController");
        }

        return $this->render(
            "register.html.twig",
            [
                'form' => $form->createView(),
            ]
        );
    }

}