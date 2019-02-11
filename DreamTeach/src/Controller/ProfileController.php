<?php

namespace App\Controller;


use App\Entity\Session;
use App\Entity\Student;
use App\Entity\Training;
use App\Form\UploadPicture;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

/**
 * Class StudentController
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 */
class ProfileController extends AbstractController
{
    /**
     * @Route("/deleteProfile", name="deleteProfile")
     * @IsGranted("ROLE_USER")
     */
    public function deleteProfile()
    {
        $repository = $this->getDoctrine()->getRepository(Student::class);
        $user = $repository->find($this->getUser()->getId());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();

        return $this->render("empty.html.twig");
    }

    /**
     * Permet d'ajouter la séance idSession à l'utilisateur connecté
     * @Route("/accueil/addSession/{idSession}", name="AddSession")
     * @param $idSession
     */
    public function addSession($idSession)
    {
        //TODO : Gérer les erreurs

        /** @var Student $student */
        $student = $this->getUser();
        /** @var Session $listeSession */
        $listeSession = $student->getSessionid();

        $tmp = array();
        $listeSessionEtudiant = array();

        // On parcourt les séances auxquelles l'utilisateur est déjà inscrit
        foreach($listeSession as $session)
        {
            // On ajoute les séances
            array_push($tmp, $session->getId());
        }

        foreach ($tmp as $ss)
        {
            // On ajoute les ID des sessions
            array_push($listeSessionEtudiant, $ss);
        }

        if(in_array($idSession,$listeSessionEtudiant))
        {
            die("c'est déjà dans ton agenda");
        }
        else
        {
            $repository = $this->getDoctrine()->getRepository(Session::class);
            $session = $repository->find($idSession);
            $student->addSessionid($session);
            $em = $this->getDoctrine()->getManager();
            $em->persist($student);
            $em->flush();
            die("Ajouté dans ton agenda !");
        }
    }
}