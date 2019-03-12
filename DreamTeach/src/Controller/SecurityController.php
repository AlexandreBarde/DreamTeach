<?php

namespace App\Controller;

use App\Service\BadgeService;
use App\Service\EmailService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/", name="app_login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if($this->getUser() !== null)
            return $this->redirectToRoute("default_student_connected");
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {}

    /**
     * @Route("/forgotPassword", name="forgotPassword")
     * @param Request $request
     * @return Response
     */
    public function forgotPassword(Request $request)
    {
        return $this->render('forgotPassword.html.twig', ["user" => $this->getUser()]);
    }

    /**
     * @Route("sendMail", name="sendMail")
     * @param \Swift_Mailer $mailer
     * @return Response
     */
    public function index(\Swift_Mailer $mailer)
    {
        EmailService::sendMail(
            "ptutdreamteach@gmail.com",
            "Salut " . $this->getUser()->getLastname() .  " " . $this->getUser()->getFirstname() . " !",
            $this->renderView("base.mail.html.twig"),
            $mailer
        );
        return $this->render("base.html.twig");
    }

}
