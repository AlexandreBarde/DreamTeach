<?php
/**
 * Created by PhpStorm.
 * User: Adel
 * Date: 04/02/2019
 * Time: 10:21
 */

namespace App\Controller;

use App\Entity\School;
use App\Entity\Student;
use App\Entity\Training;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ProfileController extends AbstractController
{

    /**
     * @Route("/createProfile", name="createProfile")
     */
    public function createProfile()
    {
        return $this->render("createProfile.html.twig");
    }
}