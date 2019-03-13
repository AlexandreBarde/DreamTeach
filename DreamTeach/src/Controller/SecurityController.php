<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\ResetPasswordFormType;
use App\Service\BadgeService;
use App\Service\EmailService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
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
     * @Route("sendMailForgotPassword", name="SendMailForgotPassword")
     * @param Request $request
     * @param \Swift_Mailer $mailer
     * @return string
     */
    public function sendMailForgotPassword(Request $request, \Swift_Mailer $mailer)
    {
        $email = $request->get('email');
        /** @var Student $student */
        $student = $this->getDoctrine()->getRepository(Student::class)->findOneBy(['emailaddress' => $email]);
        dump($student);
        //TODO : Changer le mot de passe de l'utilisateur et faire un formulaire pour lui en demander un nouveau
        if($student != null)
        {
            $idReset = md5(uniqid());
            EmailService::sendMail($email, "Réinitialisez le mot de passe de votre compte", $this->renderView("mail.forgotpassword.html.twig", ["idReset" => $idReset]), $mailer);
            $student->setResetPassword(true);
            $student->setResetId($idReset);
            $em = $this->getDoctrine()->getManager();
            $em->persist($student);
            $em->flush();
            $this->addFlash("success", "Un email de confirmation a été envoyé à " . $email);
            return $this->render("forgotPassword.html.twig");
        }
        else
        {
            $this->addFlash("info", "L'adresse " . $email . " ne correspond à aucun compte.");
            return $this->render("forgotPassword.html.twig");
        }
    }

    /**
     * @Route("resetPasswordForm/{idPasswordReset}", name="ResetPasswordForm")
     * @param $idPasswordReset
     * @return Response
     */
    public function resetPasswordForm(Request $request, UserPasswordEncoderInterface $encode, $idPasswordReset)
    {
        $student = $this->getDoctrine()->getRepository(Student::class)->findOneBy(['resetId' => $idPasswordReset]);
        if($student != null)
        {
            $form = $this->createForm(ResetPasswordFormType::class, $student);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid())
            {
                $student->setResetId(null);
                $student->setResetPassword(false);
                $student->setPassword($encode->encodePassword($student, $student->getPassword()));
                $em = $this->getDoctrine()->getManager();
                $em->persist($student);
                $em->flush();
                $this->addFlash("success", "Votre mot de passe a été changé !");
            }
            return $this->render('password.reset.form.html.twig', ['form' => $form->createView()]);
        }
        else
        {
            $this->addFlash("info", "Le lien de réinitialisation n'est pas correct !");
            return $this->render("forgotPassword.html.twig");        }
        //md5(uniqid());
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
