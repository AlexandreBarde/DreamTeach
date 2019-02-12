<?php

namespace App\Controller;


use App\Entity\Student;
use App\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ParametersController extends AbstractController
{
    /**
     * @Route("/parametres", name="parametres")
     */
    public function parametres()
    {
        return $this->render(
            "parametres.html.twig"
        );
    }

}