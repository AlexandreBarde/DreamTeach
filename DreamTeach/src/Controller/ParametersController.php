<?php

namespace App\Controller;


use App\Entity\Student;
use App\Form\RegisterType;
use App\Form\ResetEmailAddressType;
use App\Form\ResetPasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ParametersController extends AbstractController
{
    /**
     * @Route("/parametres", name="parametres")
     */
    public function parametres(Request $request, UserPasswordEncoderInterface $encode)
    {
        $student = $this->getUser();
        $formPassword = $this->createForm(ResetPasswordType::class, $student);
        $formEmailAddress = $this->createForm(ResetEmailAddressType::class, $student);
        $formPassword->handleRequest($request);
        $formEmailAddress->handleRequest($request);
        $em = $this->getDoctrine()->getManager();

        if ($formPassword->isSubmitted())
        {
            $student->setPassword($encode->encodePassword($student, $this->getUser()->getPassword()));
            $em->persist($student);
            $em->flush();
            return $this->redirectToRoute("app_logout");
        }
        if ($formEmailAddress->isSubmitted())
        {
            $student->setEmailaddress($this->getUser()->getEmailaddress());
            $em->persist($student);
            $em->flush();
            return $this->redirectToRoute("app_logout");
        }
        return $this->render(
            "parametres.html.twig", ['formPassword' => $formPassword->createView(), 'formEmailAddress' => $formEmailAddress->createView()]
        );
    }

}