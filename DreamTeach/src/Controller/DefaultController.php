<?php

namespace App\Controller;


use App\Entity\School;
use App\Entity\Student;
use App\Entity\Training;
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
    public function register()
    {
        return $this->render("register.html.twig");
    }

    /**
     * @Route("/registerCheck", name="RegisterCheck")
     * @param Request $request
     * @param ObjectManager $manager
     * @param UserPasswordEncoderInterface $encoder
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function registerCheck(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
        $currentUser = $this->getUser();
        if($currentUser === null)
        {
            if($request->request->get('lastname'))
            {
                $user = new Student();
                $user->setEmailaddress($request->request->get('emailaddress'));
                $user->setPassword($request->request->get('password'));
                $user->setFirstname($request->request->get('firstname'));
                $user->setLastname($request->request->get('lastname'));
                $user->setBiography("");
                $user->setAvatar("");
                $user->setXpwon("0");

                $school = new School();
                $school->setAddress("123 rue des roses");
                $school->setCity("Toulouse");
                $school->setName("École");
                $school->setPostalcode("31000");

                $manager->persist($school);

                $training = new Training();
                $training->setDuration(0);
                $training->setTitle("Nom");
                $training->setSchoolid($school);

                $manager->persist($training);

                $user->setTrainingid($training);
                /* TODO : Faire que la biographie & avatar puisse être nulle lors de la création */

                $hash = $encoder->encodePassword($user, $user->getPassword());
                $user->setPassword($hash);
                $manager->persist($user);
                $manager->flush();
            }
        }
        return $this->render('index.html.twig');
    }

    /**
     * @Route("/sessionCreation", name="sessionCreation")
     */
    public function sessionCreation()
    {
        return $this->render("sessionCreation.html.twig");
    }


}