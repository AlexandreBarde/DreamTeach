<?php

namespace App\Controller;


use App\Entity\Student;
use App\Form\RegisterType;
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
        $formInfosPerso = $this->createForm(ResetPasswordType::class, $student);
        $formInfosPerso->handleRequest($request);

        if ($formInfosPerso->isSubmitted() && $formInfosPerso->isValid())
        {
            $actualPassword = $request->request->get('motDePasseActuel');
            dump($encode->isPasswordValid($this->getUser()->getPassword(), $actualPassword, $this->getUser()->getSalt()));
            exit;
            if($hashActualPassword == $hashOldPassword) {
                $student->setPassword($hashNewPassword);
                $em->persist($student);
                $em->flush();
                return $this->redirectToRoute("app_logout");
            } else {
                return $this->render(
                    "parametres.html.twig", ['formUser' => $formInfosPerso->createView()]
                );
            }
        }
        return $this->render(
            "parametres.html.twig", ['formUser' => $formInfosPerso->createView()]
        );
    }

}