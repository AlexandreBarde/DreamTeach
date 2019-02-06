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
     * @Route("/profile/{idStudent}", name="profile")
     */
    public function getInfoStudent($idStudent) {
        $reqUser = $this->getDoctrine()->getRepository(Student::Class);
        $user = $reqUser->find($idStudent);

        $idUser = $user->getId();
        if($idUser == $this->getUser()->getId()) {
            return $this->render("myProfile.html.twig", ["user" => $user]);
        } else {
            return $this->render("viewProfile.html.twig", ["user" => $user]);
        }

        return $this->render("viewProfile.html.twig", ["user" => $user]);

    }
    /**
     * @Route("/Profile/{idStudent}", name="profile")
     */
    public function viewMyProfile($idStudent) {
        $reqUser = $this->getDoctrine()->getRepository(Student::Class);
        $user = $reqUser->find($idStudent);
        $idUser = $user->getId();
        return $this->render("myProfile.html.twig", ["user" => $user]);

    }
}